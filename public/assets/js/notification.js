console.log("notifications.js loaded");

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded");

    fetch("/notifications")
        .then(response => response.json())
        .then(data => {
            console.log("Fetched notifications:", data);

            let notificationBadge = document.querySelector("#notificationDropdown .badge");
            if (notificationBadge) {
                notificationBadge.textContent = data.count > 0 ? data.count : "";
                console.log("Updated notification count:", data.count);
            } else {
                console.error("Notification badge not found!");
            }
        })
        .catch(error => console.error("Error fetching notifications:", error));
});
