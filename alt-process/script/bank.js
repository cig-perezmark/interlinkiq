// $(document).on("click", ".details-btn", function () {
//     let dataId = $(this).attr("data-id");
//     let $loading = $("#loading-indicator");
//     let $container = $("#va-details");

//     // Show loading indicator
//     if ($loading.length) $loading.show();
//     if ($container.length) $container.html("");

//     console.log("Sending request for employee:", dataId);

//     $.post('../api/Bank.php', { action: 'get_details', employee: dataId })
//         .done(function (response) {
//             console.log("Response received:", response);

//             try {
//                 let data = JSON.parse(response);
//                 if (data.success) {
//                     console.log("Employee details:", data.data);
//                 } else {
//                     console.error("API Error:", data.message);
//                 }
//             } catch (e) {
//                 console.error("JSON Parse Error:", e, response);
//             }
//         })
//         .fail(function (jqXHR, textStatus, errorThrown) {
//             console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
//         });
// });
