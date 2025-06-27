document.addEventListener("DOMContentLoaded", function () {
    function fetchNotifications() {
        fetch("/notifications")
            .then(response => response.json())
            .then(data => {
                // Update jumlah notifikasi di ikon
                let notificationBadge = document.querySelector("#notificationDropdown .badge");
                if (notificationBadge) {
                    notificationBadge.textContent = data.count > 0 ? data.count : "";
                }

                // Update daftar notifikasi di dropdown
                let dropdownMenu = document.querySelector("#notificationDropdown .dropdown-menu");
                if (dropdownMenu) {
                    dropdownMenu.innerHTML = "";
                    if (data.notifications.length > 0) {
                        data.notifications.forEach(notif => {
                            let item = document.createElement("a");
                            item.classList.add("dropdown-item");
                            item.href = notif.url || "#";
                            item.innerHTML = `<i class="fas fa-envelope mr-2"></i> ${notif.message}`;
                            dropdownMenu.appendChild(item);
                        });
                    } else {
                        dropdownMenu.innerHTML = '<span class="dropdown-item text-muted">Tidak ada notifikasi</span>';
                    }
                }
            })
            .catch(error => console.error("Gagal mengambil notifikasi:", error));
    }

    // Ambil notifikasi setiap 10 detik
    fetchNotifications();
    setInterval(fetchNotifications, 10000);
});
