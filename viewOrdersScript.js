var ordersTable = document.getElementById("viewOrdersTable");

var selectFilterHouse = document.getElementById("selectOrdersFilterByHouse");
var selectFilterPrepared = document.getElementById("selectOrdersFilterByPrepared");

function setTableOrders(orders) {

    ordersTable.innerHTML = "";

    orders.forEach(order => {
        
        var row = document.createElement("tr");

        /*TAG: change here for new viewOrder columns*/

        var dataId = document.createElement("td");
        dataId.innerText = order.orderId;
        row.appendChild(dataId);

        /*TAG: change here for new item types*/

        var dataMainItem = document.createElement("td");
        dataMainItem.innerText = order.mainItem;
        row.appendChild(dataMainItem);

        var dataSideItem = document.createElement("td");
        dataSideItem.innerText = order.sideItem;
        row.appendChild(dataSideItem);

        var dataDrinkItem = document.createElement("td");
        dataDrinkItem.innerText = order.drinkItem;
        row.appendChild(dataDrinkItem);

        var requesterName = document.createElement("td");
        requesterName.innerText = order.userForename != "" ? order.userSurname + ", " + order.userForename : order.userSurname;
        row.appendChild(requesterName);

        var userHouse = document.createElement("td");
        userHouse.innerText = order.userHouse;
        row.appendChild(userHouse);

        var prepared = document.createElement("td");
        prepared.innerText = order.prepared ? "Y" : "N";
        row.appendChild(prepared);

        var notes = document.createElement("td");
        notes.innerText = order.notes;
        row.appendChild(notes);

        var dataSetPreparedBtn = document.createElement("td");
        var setPreparedBtn = document.createElement("button");
        setPreparedBtn.innerText = order.prepared ? "Un-Prepared" : "Prepared";
        setPreparedBtn.addEventListener("click", function() {
            window.location.href="setOrderPreparedRun.php?orderId=" + order.orderId + "&state=" + !order.prepared;
        });
        dataSetPreparedBtn.appendChild(setPreparedBtn);
        row.appendChild(dataSetPreparedBtn);

        ordersTable.appendChild(row);

    });

}

function setupSelects() {

    /*TAG: change here for filter options*/
    //Set up arrays
    var houses = [];

    orders.forEach(function (order) {

        /*TAG: change here for filter options*/
        var houseName = order.userHouse;
        if (!houses.includes(houseName)) houses.push(houseName);

    });

    /*TAG: change here for filter options*/
    //Add house options
    houses.forEach(function (house) {

        var option = document.createElement("option");
        option.setAttribute("value", house);
        option.innerText = house;

        selectFilterHouse.appendChild(option);

    });

    //Set on-change listeners to all filter options
    var filterSelects = document.getElementsByClassName("viewOrdersFilterParameter");
    for (var i = 0; i < filterSelects.length; i++) {
        filterSelects[i].addEventListener("change", function() {
            filterOrders(
                /*TAG: change here for filter options*/
                selectFilterHouse.value,
                selectFilterPrepared.value
                );
        });
    };

}

window.onload = function() {

    displayAllOrders();
    setupSelects();

}

//TODO: allow filtering - use {ordersArray}.filter(function(ele) { return ele.something; });

function displayAllOrders() {
    setTableOrders(orders);
}

function filterOrders(houseName,prepared) {

    /*TAG: change here for filter options*/
    setTableOrders(orders.filter( function(ele) {
        return (ele.userHouse == houseName || houseName == "null")
        && (ele.prepared == prepared || prepared == "null")
    }));

}