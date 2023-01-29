create schema if not exists lbaw2213;
SET search_path TO lbaw2213;

DROP DOMAIN IF EXISTS Today CASCADE;
CREATE DOMAIN Today AS TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

DROP TABLE IF EXISTS order_status CASCADE;
CREATE TABLE order_status (
    id_order_status SERIAL PRIMARY KEY, 
    name TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS category CASCADE;
CREATE TABLE category (
    id_category SERIAL PRIMARY KEY, 
    name TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS brand CASCADE;
CREATE TABLE brand (
    id_brand SERIAL PRIMARY KEY, 
    name TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS wish_list CASCADE;
CREATE TABLE wish_list (
    id_wish_list SERIAL PRIMARY KEY,
    product_quantity INTEGER NOT NULL
);

DROP TABLE IF EXISTS shopping_cart CASCADE;
CREATE TABLE shopping_cart (
    id_shopping_cart SERIAL PRIMARY KEY, 
    total_price FLOAT NOT NULL DEFAULT 0.0, 
    product_quantity INTEGER NOT NULL DEFAULT 0
);

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users (
    id_user SERIAL PRIMARY KEY, 
    name TEXT NOT NULL, 
    password TEXT NOT NULL, 
    gender TEXT, 
    email TEXT NOT NULL UNIQUE, 
    date_of_birth DATE NOT NULL CHECK (date_of_birth >  '1900-01-01'), 
    photo TEXT, 
    id_wish_list INTEGER REFERENCES wish_list (id_wish_list)  ON UPDATE CASCADE, 
    id_shopping_cart INTEGER REFERENCES shopping_cart (id_shopping_cart) ON UPDATE CASCADE,
    is_admin BOOL NOT NULL DEFAULT FALSE
);

DROP TABLE IF EXISTS product CASCADE;
CREATE TABLE product (
    id_product SERIAL PRIMARY KEY, 
    name TEXT NOT NULL, 
    description TEXT NOT NULL, 
    price FLOAT NOT NULL, 
    stock INTEGER NOT NULL DEFAULT 0, 
    id_category INTEGER NOT NULL REFERENCES category (id_category) ON UPDATE CASCADE, 
    id_brand INTEGER NOT NULL REFERENCES brand (id_brand) ON UPDATE CASCADE,
    photo TEXT NOT NULL
);

DROP TABLE IF EXISTS review CASCADE;
CREATE TABLE review (
    id_review SERIAL PRIMARY KEY, 
    text TEXT NOT NULL, 
    title TEXT NOT NULL, 
    rating INTEGER NOT NULL, 
    date DATE NOT NULL CHECK(date <= CURRENT_TIMESTAMP), 
    id_user INTEGER NOT NULL REFERENCES users (id_user) ON UPDATE CASCADE, 
    id_product INTEGER NOT NULL REFERENCES product (id_product) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS address CASCADE;
CREATE TABLE address (
    id_address SERIAL PRIMARY KEY, 
    zipcode TEXT NOT NULL, 
    street TEXT NOT NULL, 
    city TEXT NOT NULL, 
    door_number INTEGER NOT NULL, 
    country TEXT NOT NULL
);

DROP TABLE IF EXISTS orders CASCADE;
CREATE TABLE orders (
    id_order SERIAL PRIMARY KEY, 
    id_order_status INTEGER NOT NULL DEFAULT(1), 
    id_address INTEGER  NOT NULL REFERENCES address (id_address) ON UPDATE CASCADE, 
    payment_method TEXT NOT NULL, 
    corfirmation INTEGER NOT NULL, 
    date DATE NOT NULL CHECK(date <= CURRENT_TIMESTAMP), 
    total_price FLOAT,
    id_user INTEGER NOT NULL REFERENCES users (id_user) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS notification CASCADE;
CREATE TABLE notification (
    id_notification SERIAL PRIMARY KEY, 
    message TEXT NOT NULL, 
    pending TEXT NOT NULL, 
    id_shopping_cart INTEGER REFERENCES shopping_cart (id_shopping_cart) ON UPDATE CASCADE,
    id_order INTEGER REFERENCES orders (id_order) ON UPDATE CASCADE,
    id_wish_list INTEGER REFERENCES wish_list (id_wish_list) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS report CASCADE;
CREATE TABLE report (
    id_review INTEGER REFERENCES review (id_review) ON UPDATE CASCADE, 
    id_user INTEGER REFERENCES users (id_user) ON UPDATE CASCADE ON DELETE CASCADE, 
    motive TEXT NOT NULL,
    date DATE NOT NULL CHECK(date <= CURRENT_TIMESTAMP), 
    status TEXT NOT NULL
);

DROP TABLE IF EXISTS ban CASCADE;
CREATE TABLE ban (
    id_admin INTEGER REFERENCES users (id_user) ON UPDATE CASCADE ON DELETE CASCADE, 
    id_customer INTEGER REFERENCES users (id_user) ON UPDATE CASCADE ON DELETE CASCADE, 
    motive TEXT NOT NULL, 
    date DATE NOT NULL CHECK (date <= CURRENT_TIMESTAMP)
);

DROP TABLE IF EXISTS add_to_wish_list CASCADE;
CREATE TABLE add_to_wish_list (
    id_product INTEGER REFERENCES product (id_product) ON UPDATE CASCADE ON DELETE CASCADE, 
    id_wish_list INTEGER REFERENCES wish_list (id_wish_list) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS add_to_shopping_cart CASCADE;
CREATE TABLE add_to_shopping_cart (
    id_product INTEGER REFERENCES product (id_product) ON UPDATE CASCADE ON DELETE CASCADE, 
    id_shopping_cart INTEGER REFERENCES shopping_cart (id_shopping_cart) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS add_to_order CASCADE;
CREATE TABLE add_to_order (
    id_product INTEGER REFERENCES product (id_product) ON UPDATE CASCADE ON DELETE CASCADE, 
    id_order INTEGER REFERENCES orders (id_order) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS customer_address CASCADE;
CREATE TABLE customer_address (
    id_user INTEGER NOT NULL REFERENCES users (id_user)  ON UPDATE CASCADE ON DELETE CASCADE, 
    id_address INTEGER REFERENCES address (id_address) ON UPDATE CASCADE
);


-- Indices --

DROP INDEX IF EXISTS id_product_review CASCADE;
CREATE INDEX id_product_review ON review USING hash (id_product);

DROP INDEX IF EXISTS id_customer_order CASCADE;
CREATE INDEX id_customer_order ON orders USING hash(id_user);

DROP INDEX IF EXISTS id_brand_product CASCADE;
CREATE INDEX id_brand_product ON product USING hash (id_brand);

-- Full text search

ALTER TABLE product
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION product_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER product_search_update
 BEFORE INSERT OR UPDATE ON product
 FOR EACH ROW
 EXECUTE PROCEDURE product_search_update();

CREATE INDEX product_search_idx ON product USING GIN (tsvectors);

-- Triggers --

CREATE OR REPLACE FUNCTION banned_reviews() 
RETURNS TRIGGER 
AS 
$BODY$
BEGIN
    UPDATE review
    SET id_user = 0
    WHERE id_user = NEW.id_customer;
	RETURN NEW;
END;
$BODY$ 
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS banned_reviews ON banned_reviews CASCADE;
CREATE TRIGGER banned_reviews 
AFTER INSERT
ON ban
FOR EACH ROW
EXECUTE PROCEDURE banned_reviews();

---

CREATE OR REPLACE FUNCTION add_order_status_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF ( NEW.id_order_status != OLD.id_order_status) THEN
        INSERT INTO notification (message, pending, id_order) VALUES ('Order changed status','yes', OLD.id_order);
    END IF; 
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS order_status_notif ON add_order_status_notification CASCADE;
CREATE TRIGGER order_status_notif AFTER UPDATE ON orders
FOR EACH ROW
EXECUTE PROCEDURE add_order_status_notification();

---

CREATE OR REPLACE FUNCTION add_product_to_cart()
RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE shopping_cart
    SET total_price = total_price + (SELECT price FROM product WHERE id_product = NEW.id_product)
    WHERE id_shopping_cart = NEW.id_shopping_cart;
    
    UPDATE shopping_cart
    SET product_quantity = product_quantity + 1
    WHERE id_shopping_cart = NEW.id_shopping_cart;
	RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS add_product_to_cart ON add_product_to_cart CASCADE;
CREATE TRIGGER add_product_to_cart AFTER INSERT
ON add_to_shopping_cart
FOR EACH ROW
EXECUTE PROCEDURE add_product_to_cart();

---

CREATE OR REPLACE FUNCTION remove_product_from_cart()
RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE shopping_cart
    SET total_price = total_price - (SELECT price FROM product WHERE id_product = OLD.id_product)
    WHERE id_shopping_cart = OLD.id_shopping_cart;
    
    UPDATE shopping_cart
    SET product_quantity = product_quantity - 1
    WHERE id_shopping_cart = OLD.id_shopping_cart;
	RETURN OLD;
END;
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS remove_product_from_cart ON remove_product_from_cart CASCADE;
CREATE TRIGGER remove_product_from_cart AFTER DELETE
ON add_to_shopping_cart
FOR EACH ROW
EXECUTE PROCEDURE remove_product_from_cart();

---

CREATE OR REPLACE FUNCTION add_product_to_wishlist()
RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE wish_list
    SET product_quantity = product_quantity + 1
    WHERE id_wish_list = NEW.id_wish_list ;
	RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS add_product_to_wishlist ON add_product_to_wishlist CASCADE;
CREATE TRIGGER add_product_to_wishlist AFTER INSERT
ON add_to_wish_list
FOR EACH ROW
EXECUTE PROCEDURE add_product_to_wishlist();



--- Inserts

INSERT INTO order_status (id_order_status, name) VALUES (1,'Processing');
INSERT INTO order_status (id_order_status, name) VALUES (2,'Delivering');
INSERT INTO order_status (id_order_status, name) VALUES (3,'Finished');
INSERT INTO order_status (id_order_status, name) VALUES (4,'Delayed');
INSERT INTO order_status (id_order_status, name) VALUES (5,'Canceled');

INSERT INTO category (id_category, name) VALUES (1,'Men');
INSERT INTO category (id_category, name) VALUES (2,'Women');
INSERT INTO category (id_category, name) VALUES (3,'Child');
INSERT INTO category (id_category, name) VALUES (4,'Unisex');

INSERT INTO brand (id_brand, name) VALUES (1, 'Gucci');
INSERT INTO brand (id_brand, name) VALUES (2, 'Ray-Ban');
INSERT INTO brand (id_brand, name) VALUES (3, 'Versace');
INSERT INTO brand (id_brand, name) VALUES (4, 'Boss');

INSERT INTO wish_list (id_wish_list, product_quantity) VALUES (0, 0);
INSERT INTO wish_list (id_wish_list, product_quantity) VALUES (1, 0);
INSERT INTO wish_list (id_wish_list, product_quantity) VALUES (2, 0);
INSERT INTO wish_list (id_wish_list, product_quantity) VALUES (3, 0);
INSERT INTO wish_list (id_wish_list, product_quantity) VALUES (4, 0);

INSERT INTO shopping_cart (id_shopping_cart, total_price, product_quantity) VALUES (0, 0, 0);
INSERT INTO shopping_cart (id_shopping_cart, total_price, product_quantity) VALUES (1, 0, 0);
INSERT INTO shopping_cart (id_shopping_cart, total_price, product_quantity) VALUES (2, 0, 0); 
INSERT INTO shopping_cart (id_shopping_cart, total_price, product_quantity) VALUES (3, 0, 0);
INSERT INTO shopping_cart (id_shopping_cart, total_price, product_quantity) VALUES (4, 0, 0);

INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (0, 'anonimo', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', '', 'anonimous@mail.com', '1901-01-01', '', 0, 0, False);
INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (1, 'Marta', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'female', 'marta@mail.com', '1998-01-27', 'marta.jpg', NULL, NULL, True);
INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (2, 'Luis', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'male', 'luis@mail.com','1975-07-17', 'luis.jpg',NULL, NULL, True);
INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (3, 'John', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'male', 'john@mail.com','2000-09-17', 'john.jpg',NULL, NULL, True);
INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (4, 'Cath', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'other', 'cath@mail.com','1990-05-23', 'cath.jpg',NULL, NULL, True);

INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (5, 'João', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'male', 'joao@mail.com', '2000-01-12', 'joao.jpg', 1, 1, False);
INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (6, 'Maria', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'female', 'maria@mail.com', '2002-01-22', 'maria.jpg', 2, 2, False);
INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (7, 'Marco', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'other', 'marco@mail.com', '1997-05-11','marco.jpg', 3, 3, False);
INSERT INTO users (id_user, name, password, gender, email, date_of_birth, photo, id_wish_list, id_shopping_cart, is_admin) VALUES (8, 'Rui', '$2y$10$JcTenlj/QYXXYpF33zVQ9ebzmlkplettbydxNem3OgFUL53aary8m', 'male', 'rui@mail.com', '1988-03-11', 'rui.jpg', 4, 4, False);


INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (1, 'Venm Hybrid', 'TheGrefg pays homage to one of the most acclaimed shooters in video game history with these sunglasses from their SS22 collection. Inspired by the Fortnite color palette, this model combines black frames with a polished finish and a dark mirrored lens with an iridescent effect in shades of fuchsia, yellow and green.', 47, 15, 3,1, 'venm-hybrid.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (2, 'Clear Blue Warwick', 'It combines a gray matte carey frame with clear blue mirrored lenses, this seasons most coveted color combination.', 99.99, 50, 3,2,'clear-blue-warwick.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (3, 'Polarized Crystal Pink', 'This hybrid model has a matte white TR90 frame front with a keyhole bridge and rounded rims, combined with rose gold stainless steel temples and matte white temple tips. Polarized lenses are mirrored in pink.', 59.99, 100, 2,3,'polarized-crystal-pink.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (4, 'SOUR - Black Dark', 'A model of rectangular sunglasses inspired by the 90s that stands out for its minimalist aesthetic. The frame is lightweight and made from stainless steel and the temples are finished in extra-long black acetate for added comfort and texture.', 150, 1, 1,4,'sour-black-dark.jpg');


INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (5, 'Polarized Black Rose Gold', 'Black frame with matte finish and rose gold mirrored lenses.', 49.99, 15, 4,1, 'black-rose-gold.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (6, 'ONE DREAM - Crystal Grey', 'In ONE DREAM, our all-time best-selling ONE frame shape is paired with a one-piece, rimless lens. This matte white model has a dark gray gradient lens.', 99.99, 50, 4,2, 'one-dream-crystal-grey.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (7, 'GRADIENTPURPLE', 'The Idle is a classic sunglass shape but with a full rimless mask lens. This dark purple gradient template has glossy black stems.', 59.99, 100, 2,3,'idle-gradient-purple.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (8, 'Clear Blue Warwick', 'Combines a gray matte carey frame with clear blue mirrored lenses, this seasons most coveted color combination', 75, 1, 1,4, 'carey-grey-clear-blue-warwick.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (9, 'Polarized Air Joker', 'Clear frame and dark violet blue mirrored lenses.', 100.50, 15, 1,1, 'polarized-air-joker.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (10, 'APEROL NEON DARK', 'This neon yellow and black lenses model from the pioneering artist of the Latin trap movement features a slim chunky frame with a geometric cut that recalls the opulent style of the 90s street music scene. A model that claims its own style and updates street codes.', 99.99, 50, 3,2, 'aperol-neon-dark.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (11, 'ALL IN - Rose Gold Lilac', 'A sophisticated cats eye design comes to life in this model with a thin rose gold stainless steel frame. Brown and lilac gradient lenses complement these sunglasses created on a timeless base of pure elegance.', 159.99, 100, 2,3, 'all-in-rose-gold-lilac.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (12, 'RUSHHOUR - OCEAN', 'Retro inspiration in this avant-garde hybrid design. It combines a silver metal frame with a matte finish with the temple tips and bezel in icy white translucent TR90. The white of the slits along the temples and the ocean blue lenses add to the freshness of this design.', 50, 1, 1,4,'rushhour-ocean.jpg');

INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (13, 'Gucci - Cat eye', 'Crafted from a combination of black acetate and gold-toned metal, these frames are defined by their flexible structure. Gucci continues to reimagine everyday accessories in new ways and fulfill contemporary desires.', 410, 15, 1,1,'gucci.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (14, 'Rayban - RB2180', 'Modern design has gone full circle as Ray-Ban takes the classic round shape on another revolution. Along with distinctive rivets and Ray-Ban shaped temples, these styles feature a sleek flattened bridge and stylish tinted lenses in appealing gradient options. With cool colors on offer, including modern tones and versatile classics, you can choose the model that suits your own personal style revolution.', 99.99, 50, 3,2,'rayban1.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (15, 'Rayban - WAYFARER EASE', 'Instantly recognizable, totally irresistible – theres something special about the Wayfarer. The world’s most famous shades are getting a distinctly laid-back upgrade – think classic blacks and beiges paired with gradient mirrored lenses that are designed to slide on fast and wear with total comfort. Just focus on what’s important – feeling like a rockstar. Frames available with gradient mirrored lenses and loads of diverse colour choices.', 59.99, 100, 2,3,'rayban2.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (16, 'Rayban - ELON', 'Inspired by popular modern Ray-Ban styles, RB3958 Elon sunglasses are a fresh new look for summer. Crafted from metal, with a polished black finish and green classic G-15 lenses, these shades are as cool as they come.', 750, 1, 1,4,'rayban3.jpg');


INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (17, 'CORAL-SMOKY', 'This model has a narrow shape and geometric dynamics that contrast with the wide temples to create a high-impact design. These coral acetate sunglasses have a revolutionary shape that will amaze everyone who looks at them.', 40, 4, 2,4,'coral-smoky.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (18, 'ONE CROSSWALK - NAVY', 'Hybrid redesign of our iconic ONE model, featuring a classic navy square square front, gold gradient lenses, gold metallic temples and translucent white terminals. A highly urban and elegant design with a sporty essence.', 90, 60, 3,4,'one-crosswalk-navy.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (19, 'ONE RAW - Polarized Air Emerald', 'The ONE model is our all-time classic design. This model, from the Made in Spain collection, has a shiny transparent frame with silver logos on the temples, and the POLARIZED lenses are mirrored and iridescent in an emerald green tone.', 30, 60, 4,2,'one-raw-polarized-air-emerald.jpg');

INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (20, 'Midtown-Polarized Rose Gold', 'A round, metallic model with pink polarized and mirrored lenses. The rose gold stainless steel frame has pointed accents along the frame and bridge, and the slender temples are complemented by translucent, glossy white tips.', 50, 20, 4,1,'midtown-polarized-rose-gold.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (21, 'Rose Gold Warwick', 'It combines a gray matte carey frame with rose gold mirrored lenses for a more elegant accessory.', 40, 35, 2,2,'rose-gold-warwick.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (22, 'POLAR - DIAMOND NEON EMERALD', 'Undoubtedly the boldest model in the Polar collection, our answer to this season Future Commuter 2.0 urban fashion trend. The wraparound frame of this half-air frame design, a straight top front and TR90 bridge comes in neon green with an emerald-hued iridescent shield lens and mirror effect.', 69.99, 40, 1,3,'polar-diamond-neon-emerald.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (23, 'MANHATTAN - ORANGE TERRACOTA', 'Orange acetate cat eye sunglasses with a glossy finish and terracotta gradient lenses. The lines that run through this model are exaggerated and angular, making them the perfect complement to a bold yet sophisticated look.', 79.99,30, 2,3,'manhattan-orange-terracota.jpg');
INSERT INTO product (id_product, name, description, price, stock, id_category, id_brand, photo) VALUES (24, 'ONE RAW - Polarized Air Emerald', 'Ready for all. Ready for this season. Pierre personally chose this model for its comfort, lightness and cosmopolitan aesthetics for his Hawkers SS22 collection. A personalized design with its seal that combines the front and ends of the transparent temples with a silver metallic bridge and temples and gradient lenses in twilight blue.', 44.99, 7, 3,4,'pierre-gasly-dealer-air.jpg');


INSERT INTO review (id_review, text, title, rating, date, id_user, id_product) VALUES (1, 'Best glasses EVEEEER', 'THE BEST', 4, '2022-10-04', 7,6);
INSERT INTO review (id_review, text, title, rating, date, id_user, id_product) VALUES (2, 'It broke when I put them on', 'WTF???', 1, '2022-9-2', 8,3);
INSERT INTO review (id_review, text, title, rating, date, id_user, id_product) VALUES (3, 'They are the best', 'It is true', 5, '2022-10-22', 6,2);
INSERT INTO review (id_review, text, title, rating, date, id_user, id_product) VALUES (4, 'They are bigger than my head', 'ITS TOO BIG', 1 , '2022-10-20', 6,4);

INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (1, '4440-321', 'Next street', 'Portland', 4, 'USA');
INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (2, '4321-512', 'This street', 'HongKong', 2, 'China');
INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (3, '8739-236', 'That street', 'Porto', 1, 'Portugal');
INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (4, '7923-881', 'Barro street', 'Berlin', 321, 'Germany');
INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (5, '4460-366', 'Next street', 'Portland', 4, 'USA');
INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (6, '4355-512', 'This street', 'HongKong', 2, 'France');
INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (7, '8739-256', 'That street', 'Porto', 1, 'Belgium');
INSERT INTO address (id_address, zipcode, street, city, door_number, country) VALUES (8, '4563-871', 'Barro street', 'Berlin', 321, 'Norway');

INSERT INTO customer_address(id_user, id_address) VALUES (5,1);
INSERT INTO customer_address(id_user, id_address) VALUES (6,2);
INSERT INTO customer_address(id_user, id_address) VALUES (6,5);
INSERT INTO customer_address(id_user, id_address) VALUES (6,6);
INSERT INTO customer_address(id_user, id_address) VALUES (6,8);
INSERT INTO customer_address(id_user, id_address) VALUES (6,7);
INSERT INTO customer_address(id_user, id_address) VALUES (7,3);
INSERT INTO customer_address(id_user, id_address) VALUES (8,4);

INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (1, 1, 1, 'VISA', 0, '2022-04-05', 400.90, 5);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (2, 3, 2, 'MASTERCARD', 0, '2022-04-05', 400.90, 6);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (3, 1, 3, 'VISA', 0,'2022-04-05', 400.90, 7);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (4, 1, 4, 'BANKTRANSFER', 1,'2022-04-05', 400.90, 8);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (5, 5, 1, 'VISA', 0, '2022-04-05', 400.90, 5);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (6, 3, 2, 'MASTERCARD', 0, '2022-04-05', 234.98, 6);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (7, 3, 6, 'MASTERCARD', 0, '2022-07-08', 60, 6);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (8, 3, 7, 'MASTERCARD', 0, '2022-11-05', 200.50, 6);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (9, 1, 8, 'MASTERCARD', 0, '2022-11-12', 410.48, 6);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (10, 2, 6, 'MASTERCARD', 0, '2022-07-05', 70, 6);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (11, 4, 6, 'MASTERCARD', 0, '2022-04-14', 120, 6);
INSERT INTO orders (id_order, id_order_status, id_address, payment_method, corfirmation, date, total_price, id_user) VALUES (12, 3, 7, 'MASTERCARD', 0, '2022-07-08', 400.90, 6);

INSERT INTO notification (id_notification, message, pending, id_shopping_cart, id_order, id_wish_list) VALUES (1, '30% of EVERYTHING', 'BIG DISCOUNT!!!', 1, NULL, 1);
INSERT INTO notification (id_notification, message, pending, id_shopping_cart, id_order, id_wish_list) VALUES (2, 'GET2BUY1', 'TWO4ONE', 2, NULL, 2);
INSERT INTO notification (id_notification, message, pending, id_shopping_cart, id_order, id_wish_list) VALUES (3, '30% of EVERYTHING', 'BIG DISCOUNT!!!', 2, NULL, 2);
INSERT INTO notification (id_notification, message, pending, id_shopping_cart, id_order, id_wish_list) VALUES (4, 'No shipping fee on next order', 'NO SHIPPING FEE!!', 4, 4, NULL);

-- INSERT INTO report (id_review, id_user, motive) VALUES (2, 2, 'Bad language');
-- INSERT INTO report (id_review, id_user, motive) VALUES (4, 4, 'Cross-site scripting');

INSERT INTO ban (id_admin, id_customer, motive, date) VALUES (1, 5, 'Bad language','2022-01-02');
INSERT INTO ban (id_admin, id_customer, motive, date) VALUES (2, 8, 'Cross-site scripting','2021-10-02');

INSERT INTO add_to_wish_list (id_product, id_wish_list) VALUES (1,1);
INSERT INTO add_to_wish_list (id_product, id_wish_list) VALUES (2,2);
INSERT INTO add_to_wish_list (id_product, id_wish_list) VALUES (3,3);

INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (2, 2);
INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (1, 2);
INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (4, 2);
INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (3, 1);
INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (5, 2);
INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (6, 2);
INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (7, 2);
INSERT INTO add_to_shopping_cart (id_product, id_shopping_cart) VALUES (8, 2);

INSERT INTO add_to_order (id_product, id_order) VALUES (1,5);
INSERT INTO add_to_order (id_product, id_order) VALUES (2,5);
INSERT INTO add_to_order (id_product, id_order) VALUES (3,3);
INSERT INTO add_to_order (id_product, id_order) VALUES (6,6);
INSERT INTO add_to_order (id_product, id_order) VALUES (7,6);
INSERT INTO add_to_order (id_product, id_order) VALUES (8,6);
INSERT INTO add_to_order (id_product, id_order) VALUES (10,9);
INSERT INTO add_to_order (id_product, id_order) VALUES (11,9);
INSERT INTO add_to_order (id_product, id_order) VALUES (12,9);
INSERT INTO add_to_order (id_product, id_order) VALUES (9,9);

----------------

---

CREATE OR REPLACE FUNCTION add_shopping_cart_and_whishlist()
RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO wish_list (id_wish_list, product_quantity) VALUES (NEW.id_user, 0);
    INSERT INTO shopping_cart (id_shopping_cart, total_price, product_quantity) VALUES (NEW.id_user, 0, 0);
    UPDATE users
	SET id_wish_list = NEW.id_user
	WHERE id_user = NEW.id_user;
    UPDATE users
	SET id_shopping_cart = NEW.id_user
	WHERE id_user = NEW.id_user;
	RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;   

DROP TRIGGER IF EXISTS add_shopping_cart_and_whishlist ON add_shopping_cart_and_whishlist CASCADE;
CREATE TRIGGER add_shopping_cart_and_whishlist AFTER INSERT
ON users
FOR EACH ROW
EXECUTE PROCEDURE add_shopping_cart_and_whishlist();



SELECT setval('lbaw2213.orders_id_order_seq', (SELECT MAX(id_order) FROM lbaw2213.orders));

SELECT setval('lbaw2213.review_id_review_seq', (SELECT MAX(id_review) FROM lbaw2213.review));

SELECT setval('lbaw2213.users_id_user_seq', (SELECT MAX(id_user) FROM lbaw2213.users));

SELECT setval('lbaw2213.product_id_product_seq', (SELECT MAX(id_product) FROM lbaw2213.product));

SELECT setval('lbaw2213.address_id_address_seq', (SELECT MAX(id_address) FROM lbaw2213.address));

SELECT setval('lbaw2213.shopping_cart_id_shopping_cart_seq', (SELECT MAX(id_shopping_cart) FROM lbaw2213.shopping_cart));

SELECT setval('lbaw2213.notification_id_notification_seq', (SELECT MAX(id_notification) FROM lbaw2213.notification));