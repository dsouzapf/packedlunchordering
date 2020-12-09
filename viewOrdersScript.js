var ordersTable = document.getElementById("viewOrdersTable");

function setTableOrders(orders) {

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

window.onload = function() {

    setTableOrders(orders);

}

//TODO: allow filtering - use {ordersArray}.filter(function(ele) { return ele.something; });