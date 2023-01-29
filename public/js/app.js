function addEventListeners() {

  /*let confirmReviewEdit = document.querySelectorAll('.confirm_edit_review');
  [].forEach.call(confirmReviewEdit, function(confirmreviewedit) {
    confirmreviewedit.addEventListener('click', ReviewEditRequest);
  });*/

  let deleteReviewByReport = document.querySelectorAll('.delete_review_by_report');
  [].forEach.call(deleteReviewByReport, function(deletereviewbyreport) {
    deletereviewbyreport.addEventListener('click', deleterReviewByReportRequest);
  });

  let banUserByReport = document.querySelectorAll('.ban_by_report');
  [].forEach.call(banUserByReport, function(banuserbyreport) {
    banuserbyreport.addEventListener('click', banUserByReportRequest);
  });

  let stars = document.querySelectorAll('.star_label');
  [].forEach.call(stars, function(starfunction) {
    starfunction.addEventListener('click', changeStarsRequest);
  });

  let dismissReport = document.querySelectorAll('.close_report');
  [].forEach.call(dismissReport, function(dismissreport) {
    dismissreport.addEventListener('click', dismissReportRequest);
  });

  let starsEdit = document.querySelectorAll('.star_label-edit');
  [].forEach.call(starsEdit, function(stareditfunction) {
    stareditfunction.addEventListener('click', changeEditStarsRequest);
  });

  let openReview = document.querySelectorAll('button#open_review');
  [].forEach.call(openReview, function(openreview) {
    openreview.addEventListener('click', showReviewFormRequest);
  });

  let editReview = document.querySelectorAll('.edit_review');
  [].forEach.call(editReview, function(editreview) {
    editreview.addEventListener('click', showEditReviewFormRequest);
  });

  let reportReview = document.querySelectorAll('button.report_review');
  [].forEach.call(reportReview, function(reportreview) {
    reportreview.addEventListener('click', showReportReviewRequest);
  });
  
  let sendReport = document.querySelectorAll('button.send_report');
  [].forEach.call(sendReport, function(sendreport) {
    sendreport.addEventListener('click', SendReportReviewRequest);
  });/*
  let cancelReport = document.querySelectorAll('button.cancel_report');
  [].forEach.call(cancelReport, function(cancelreport) {
    cancelreport.addEventListener('click', closeReportReviewRequest);
  });*/
  let closeReview = document.querySelectorAll('button#close_review');
  [].forEach.call(closeReview, function(closereview) {
    closereview.addEventListener('click', closeReviewFormRequest);
  });

  let removeReview = document.querySelectorAll('button.remove_review');
  [].forEach.call(removeReview, function(removereview) {
    removereview.addEventListener('click', removeReviewFormRequest);
  });

  let productBuyers = document.querySelectorAll('button.buy');
  [].forEach.call(productBuyers, function(buyer) {
    buyer.addEventListener('click', sendBuyProductRequest);
  });
  
  let productRemovers = document.querySelectorAll('button.remove');
  [].forEach.call(productRemovers, function(remover) {
    remover.addEventListener('click', sendRemoveProductRequest);
  });
  let productWishAdders = document.querySelectorAll('button.wishlist');
  [].forEach.call(productWishAdders, function(adder) {
    adder.addEventListener('click', sendWishProductRequest);
  });
  let productWishRemovers = document.querySelectorAll('button.removewishlist');
  [].forEach.call(productWishRemovers, function(dewisher) {
    dewisher.addEventListener('click', sendDewishProductRequest);
  });
}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function changeStarsRequest(){
  let id = this.getAttribute('id');
  let labels = document.querySelectorAll('.star_label');
  let label;
  for(label of labels){
    if(label.id<=id){label.innerHTML="<i class='fa-solid fa-star'></i>"}
    else{
      label.innerHTML="<i class='fa-regular fa-star'></i>"
    }
  }
}

function banUserByReportRequest(){
  let id = this.getAttribute('id');
  let motive = this.getAttribute('motive');
  let id_review = this.getAttribute('review');
  sendAjaxRequest('post', '/api/ban/' + id+'/'+motive+'/'+id_review,null, checkHandler);
}


function deleterReviewByReportRequest(){
  let id = this.getAttribute('id');
  sendAjaxRequest('delete', '/api/review/' + id,null, checkHandler);
}

function changeEditStarsRequest(){
  let id = this.getAttribute('id');
  let labels = document.querySelectorAll('.star_label-edit');
  let label;
  for(label of labels){
    if(label.id<=id){label.innerHTML="<i class='fa-solid fa-star'></i>"}
    else{
      label.innerHTML="<i class='fa-regular fa-star'></i>"
    }
  }
}


function showEditReviewFormRequest(){
  let id = this.getAttribute('id');
  let review = document.getElementById('review-'+id);
  let edit = document.getElementById('edit_review-'+id);
  review.hidden = true;
  edit.hidden= false;
  let rating=  document.getElementById('rating-'+id).value;
  let label = document.querySelector('#edit_review-'+id +' .star-rating'+ ' .label_'+rating);
  label.click();

}

function showReportReviewRequest(){
  let id = this.getAttribute('id');
  let form = document.getElementById('report_form-'+id);
  form.hidden=false;
}

function closeReportReviewRequest(){
  let id = this.getAttribute('id');
  let form = document.getElementById('report_form-'+id);
  form.hidden=true;
}

function showReviewFormRequest(){
  let plus = document.getElementById('open_review');
  let minus = document.getElementById('close_review');
  let form = document.getElementById('create_review');
  plus.hidden=true;
  minus.hidden=false;
  form.hidden=false;
}

function dismissReportRequest(){
  let div = this.parentElement.parentElement;
  let id_user= div.getAttribute('user');
  let id_review= div.getAttribute('review');
  let motive= div.getAttribute('motive');
  div.hidden=true; 
  sendAjaxRequest('put', '/api/report/dismiss/'+ id_user +'/'+id_review+'/'+motive,null,null);
}

function closeReviewFormRequest(){
  let plus = document.getElementById('open_review');
  let minus = document.getElementById('close_review');
  let form = document.getElementById('create_review');
  plus.hidden=false;
  minus.hidden=true;
  form.hidden=true;
}

function ReviewEditRequest(){
  let id = this.getAttribute('id');
  let new_title = document.getElementById('edit_title-'+id).value;
  let new_text = document.getElementById('edit_text-'+id).value;
  let form = document.getElementById('edit_review-'+id);
  let new_rating = form.querySelector('input[name="rating"]:checked').value;
  sendAjaxRequest('post', '/api/review/edit/' + id+'/'+new_title+'/'+new_text+'/'+new_rating,null,reviewEditHandler );
}



function SendReportReviewRequest(){
  let id = this.getAttribute('id');
  let motive = document.getElementById('motive-'+id);
  let motivetext = motive.value;
  sendAjaxRequest('post', '/api/report/review/' + id+'/'+motivetext,null, reportSenderHandler);
}

function  removeReviewFormRequest(){
  let id = this.getAttribute('id');
  sendAjaxRequest('delete', '/api/review/' + id,null, reviewRemoverHandler);
}

function sendBuyProductRequest() {
  let id = this.getAttribute('id');
  sendAjaxRequest('post', '/api/product/' + id,null, productBuyerHandler);
}

function sendRemoveProductRequest() {
  let id = this.getAttribute('id');
  sendAjaxRequest('delete', '/api/product/' + id,null, productRemoverHandler);
}

function sendWishProductRequest() {
  let id = this.getAttribute('id');
  sendAjaxRequest('post', '/api/wishlist/product/' + id,null, productWishAddHandler);
}

function sendDewishProductRequest(){
  let id = this.getAttribute('id');
  sendAjaxRequest('delete', '/api/wishlist/product/' + id,null, productWishRemoveHandler);
}

function reviewRemoverHandler(){
  let reviewid = JSON.parse(this.responseText); 
  let review = document.getElementById("review-"+reviewid);
  review.remove();
}

function reviewEditHandler(){
  let reviewid = JSON.parse(this.responseText); 
  let review = document.getElementById('review-'+reviewid);
  let edit = document.getElementById('edit_review-'+reviewid);
  review.hidden = false;
  edit.hidden= true;
  window.location.reload();
}

function productBuyerHandler(){
  let product = JSON.parse(this.responseText);
  let paragraf = document.getElementById('numof'+product.id_product);
  let prodnum = paragraf.innerText;
  let prod_article = document.getElementById('cart_product_'+product.id_product);
  let price_paragraf = document.getElementById('price');

  if(paragraf===null){
  }
  else{
   paragraf.innerText= parseInt(prodnum)+1;
   if(prod_article !==null){
    let cart_price = price_paragraf.innerText;
    var new_cart_price = (parseFloat(cart_price) + parseFloat(product.price)).toFixed(2);
    price_paragraf.innerText= new_cart_price + " €";
   }
  }
}

function productRemoverHandler(){
  let product = JSON.parse(this.responseText);
  let paragraf = document.getElementById('numof'+product.id_product);
  let prodnum = paragraf.innerText;
  let prod_article = document.getElementById('cart_product_'+product.id_product);
  let price_paragraf = document.getElementById('price');
  
  if(paragraf===null){
  }
  else{
    if(parseInt(prodnum)>0){
      paragraf.innerText= parseInt(prodnum)-1;
      if(prod_article !==null){
        let cart_price = price_paragraf.innerText;
        var new_cart_price = (parseFloat(cart_price) - parseFloat(product.price)).toFixed(2);
        price_paragraf.innerText= new_cart_price + " €";
        if(parseInt(prodnum) === 1){
          prod_article.innerHTML="";

        }  
      }
    }
  }
}

function productWishAddHandler(){
  let product = JSON.parse(this.responseText);
  let button1 = document.querySelector('[name="addwishlistbutton"]');
  let button2 = document.querySelector('[name="removewishlistbutton"]');
  button1.hidden=true;
  button2.hidden=false;

}
function productWishRemoveHandler(){
  let product = JSON.parse(this.responseText);
  let button1 = document.querySelector('[name="removewishlistbutton"]');
  let button2 = document.querySelector('[name="addwishlistbutton"]');
  button1.hidden=true;
  button2.hidden=false;
}

var modal = document.getElementById('id01');
window.onclick = function(event) {
if (event.target == modal) {
    modal.style.display = "none";
    }
}

function reportSenderHandler(){
  let report = JSON.parse(this.responseText);
  report_input.value=null;
}

function checkHandler(){
  let report = JSON.parse(this.responseText);
}
addEventListeners();
