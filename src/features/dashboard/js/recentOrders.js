function getRecentOrders() {
    // Table Data
    const orders = [
        {
            courseName: "JavaScript Tutorial",
            courseNumber: "85743",
            payment: "Due",
            status: {
                text: "Pending",
                color: "#ffb400",
            },
        },
        {
            courseName: "CSS Full Course",
            courseNumber: "97245",
            payment: "Refunded",
            status: {
                text: "Declined",
                color: "#ff0060",
            },
        },
        {
            courseName: "Python for Beginners",
            courseNumber: "34521",
            payment: "Paid",
            status: {
                text: "Completed",
                color: "#00ba88",
            },
        },
        {
            courseName: "React Fundamentals",
            courseNumber: "65432",
            payment: "Due",
            status: {
                text: "Pending",
                color: "#ffb400",
            },
        },
        {
            courseName: "UI/UX Design Course",
            courseNumber: "78901",
            payment: "Paid",
            status: {
                text: "Completed",
                color: "#00ba88",
            },
        },
    ];

    let recentOrderItems = $("#recentOrderItems");
    recentOrderItems.empty();

    let recentOrdersHTML = "";
    orders.forEach((order) => {
        recentOrdersHTML += `
                    <tr>
                        <td>${order.courseName}</td>
                        <td>${order.courseNumber}</td>
                        <td>${order.payment}</td>
                        <td style="color: ${order.status.color}">
                            ${order.status.text}
                        </td>
                        <td>
                            <div class="ui compact floating selection dropdown recent-orders-dd">
                                <i class="dropdown icon"></i>
                                <div class="text">Actions</div>
                                <div class="menu">
                                    <div class="item" data-value="view">View</div>
                                    <div class="item" data-value="edit">Edit</div>
                                    <div class="item" data-value="delete">Delete</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
    });

    recentOrderItems.append(recentOrdersHTML);
    recentOrderItems.find(".ui.dropdown").dropdown();

    // Add event listener to dropdown
    $(".recent-orders-dd").dropdown({
        onChange: function (value) {
            console.log(value);
            if (value === "view") {
                $(".ui.flyout").flyout("toggle");
            }
        },
    });
}

$(function () {
    getRecentOrders();
});
