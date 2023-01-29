var show_menu_options = false;
let data = {};

function getSelectedValue() {
    let id_order = document.getElementById("id_order").getAttribute("value");
    let selected_status = document.getElementById("status_list").value;

    data = {
        "id_order": id_order,
        "id_order_status": selected_status
    };
}

function sendChangeStatusRequest() {
    /*
    const map_status = new Map();

    map_status.set(1, "Processing");
    map_status.set(2, "Delivering");
    map_status.set(3, "Finished");
    map_status.set(4, "Delayed");
    map_status.set(5, "Canceled");
    */
    let id = document.getElementById("id_order").getAttribute("value");
    //let status_name = document.getElementById("status_name");
    sendAjaxRequest('PATCH', '/api/order/' + id, data, function () {
        if (this.status == 200) {
            let responseJson = JSON.parse(this.responseText);
            let status = responseJson['id_order_status'];
            console.log('status = ' + status);
            //console.log("status name = " + map_status.get(status));
            //document.getElementById("status_name").innerHTML = map_status.get(status);
            if(status == 1){
                document.getElementById("status_name").innerHTML = "Processing";
            }
            else if ( status == 2){
                document.getElementById("status_name").innerHTML = "Delivering";
            }
            else if ( status == 3){
                document.getElementById("status_name").innerHTML = "Finished";
            }
            else if ( status == 4){
                document.getElementById("status_name").innerHTML = "Delayed";
            }
            else if ( status == 5){
                document.getElementById("status_name").innerHTML = "Canceled";
            }
        }
    });
}

document.getElementById("save_changes").addEventListener("click", sendChangeStatusRequest);

function show_menu() {
    if (!show_menu_options) {
        document.getElementById("change_status").style.display = "inline";
        document.getElementById("current_status").style.display = "none";
        return show_menu_options = true;
    }
    else {
        document.getElementById("change_status").style.display = "none";
        document.getElementById("current_status").style.display = "inline";
        return show_menu_options = false;
    }
}