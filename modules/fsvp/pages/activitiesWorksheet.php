<style>
.checkFileUpload {
    display: flex;
    width: 100%;
    gap: 2rem;
}

.checkFileUpload .input-group {
    flex: 1 0 auto;
}

.frfUplDoc .row {
    display: none;
    margin-bottom: 20px;
}

.frfUplDoc:has(input:checked) .row {
    display: block;
}
</style>

<div class="d-flex margin-bottom-20" style="justify-content: end;">
    <a href="#modalFSVPQIReg" data-toggle="modal" class="btn green">
        <i class="fa fa-plus"></i>
        New
    </a>
</div>

<table class="table table-bordered table-hover" id="tableActivitiesWorksheet">
    <thead>
        <tr>
            <th>Importer Name</th>
            <th>Foreign Supplier </th>
            <th>Product(s) </th>
            <th>Evaluation Date</th>
            <th>Actions</th>
            <!-- <th data-nosort="true">Actions</th> -->
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script defer src="modules/fsvp/js/activitiesWorksheet.js"></script>