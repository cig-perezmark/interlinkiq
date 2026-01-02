$(document).ready(function () {

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        return parts.length === 2 ? parts.pop().split(";").shift() : null;
    }

    const currentUser = getCookie("first_name") || "Unknown";
    console.log("Logged in user:", currentUser);

    $(document).on("click", ".comment-btn", function () {
        const $btn  = $(this);
        const type  = $btn.data("type");
        const $input = $(`.comment-input[data-type="${type}"]`);
        const $capaid = $(`.capa-id[data-type="${type}"]`);
        const $list  = $(`.comment-list[data-type="${type}"]`);

        if (!$input.length || !$list.length) return;

        const comment = $input.val().trim();
        const id = $capaid.val().trim();
        if (!comment) return;

        // Build date
        const now = new Date();
        const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        const month = months[now.getMonth()];
        const day   = now.getDate();
        const hr12  = (now.getHours() % 12) || 12;
        const min   = now.getMinutes().toString().padStart(2, "0");
        const ampm  = now.getHours() >= 12 ? "PM" : "AM";
        const year  = now.getFullYear();
        const showYear = (year === new Date().getFullYear()) 
            ? `${day} ${month}, ${hr12}:${min}${ampm}`
            : `${day} ${month} ${year}, ${hr12}:${min}${ampm}`;

        $.ajax({
            url: "../../function.php?insertComment",
            type: "POST",
            data: {
                capa_id: id,
                type: type,
                comment: comment
            },
            success: function (res) {
                console.log("Successfully inserted to DB:", res);
                const li = `
                    <li>
                        <div class="col1">
                            <div class="cont">
                                <div class="cont-col2">
                                    <div class="desc" style="margin-left: 15px;">
                                        <span class="desc">${comment}</span>
                                        <span class="desc text-success" style="margin-left: 2em;">@${showYear}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="date" style="font-size: 13px;"> ${currentUser}</div>
                        </div>
                    </li>
                `;

                $list.prepend(li);
                $input.val("");
            },
            error: function (xhr, status, error) {
                console.error("Insert failed:", error);
                alert("Failed to add comment. Please try again.");
            }
        });
    });
});
