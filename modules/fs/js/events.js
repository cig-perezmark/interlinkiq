function events() {
    // builder tabs event
    $('a[data-toggle="tab"]').on("show.bs.tab", function () {
        // reset step selector
        $(".stepSelector select").html("<option selected disabled>None</option>").trigger("change");
        // closeSLRatingSelection();
        const target = this.getAttribute("href").replace("#", "");
        new tcTable(target);
    });

    // step dropdown selector event
    $(".stepSelector select").on("change", function () {
        const value = this.value || null;

        if (value) {
            const parent = $(this).closest(".haccpTableContainer").get(0);
            $(parent)
                .find("#" + this.value)
                .get(0)
                ?.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                    inline: "nearest",
                });
        }
    });

    // reset to first tab view when builder is hidden
    // to avoid unwanted table layout when viewed initially
    $('a[href="#haccp_builder"]').on("hide.bs.tab", function () {
        $('a[href="#product_information"]').click();
    });

    // display table/section title on tab change
    $(".builder-toc-navs a[data-toggle=tab]").click(function () {
        $("#builder-title").text(this.innerText);
    });

    $(".haccp-multiselect").multiselect({
        buttonWidth: "100%",
        enableFiltering: true,
        disableIfEmpty: true,
        maxHeight: 250,
        buttonClass: "mt-multiselect btn btn-default",
    });

    // inputs in haccp builder (basic information section)
    $("[data-inputkey]").on("input", function () {
        updBuilderData(this, this.dataset.inputkey);

        if (this.dataset.inputkey == "description") {
            $("#haccpBuilderSaveBtn").prop("disabled", this.value.trim() == "");
        }
    });

    // reset haccp team roster form when modal is hidden
    $("#modal-haccpTeamModal").on("hidden.bs.modal", function () {
        $("#modal-haccpTeamModal .modal-title").text("Add member");
        $("input[name=alternate_title]").val("");
        $("input[name=primary_title]").val("");
        $(".haccp-team-select option:selected").removeAttr("selected");
        $(".haccp-team-select").multiselect("select", "");
        $(".haccp-team-select").multiselect("refresh");
    });

    // closing client signatures modal
    $("#modal-clientUpdates").on("hide.bs.modal", function () {
        const modal = $("#modal-clientUpdates");
        modal.find("input[name=updateClientSigns]").val("");
        modal.find(".haccp-multiselect").multiselect("deselectAll");
        modal.find(".upd-esign").eSign("destroy");
        modal.find("input[name=review_date]").val();
        modal.find("input[name=approve_date]").val();
        modal.find(".upd-developer").val("");
        modal.find(".upd-develop").addClass("hide");
    });

    // clicking on sl-rating tiles in the hazard analysis
    $("#s-l-rating-selection .hazardAssessmentTable td span").on("click", selectSLRatingClickEvt);
}
