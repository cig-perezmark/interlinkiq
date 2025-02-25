<?php include __DIR__ . '/../../footer.php'; ?>

<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="assets/jSignature/jSignature.min.js"></script>
<script src="assets/global/plugins/jquery-notific8/jquery.notific8.min.js" type="text/javascript"></script>
<script src="assets/esign.js"></script>
<script src="assets/apps/scripts/todo-2.min.js" type="text/javascript"></script>

<!-- haccp builder scripts -->
<script src="modules/haccp/js/dg2temp.js"></script>
<script src="modules/haccp/js/HRow.js"></script>

<script src="modules/haccp/js/table_controls/main.js"></script>
<script src="modules/haccp/js/table_controls/hazardAnalysis.js"></script>
<script src="modules/haccp/js/table_controls/ccpDetermination.js"></script>
<script src="modules/haccp/js/table_controls/clmca.js"></script>
<script src="modules/haccp/js/table_controls/vrk.js"></script>

<!-- diagram scripts -->
<script src="modules/haccp/js/jsflow/console.js"></script>
<script src="modules/haccp/js/jsflow/lib/hammer.js"></script>
<script src="modules/haccp/js/jsflow/lib/svg-pan-zoom.min.js"></script>
<script src="modules/haccp/js/jsflow/lib/pathfinding-browser.min.js"></script>
<script type="module" src="modules/haccp/js/jsflow/index.js"></script>

<script src="modules/haccp/js/functions.js"></script>
<script src="modules/haccp/js/events.js"></script>
<script src="modules/haccp/js/apiservices.js"></script>
<script src="modules/haccp/js/index.js"></script>

<script>
document.querySelector('select[name="facility"]').dispatchEvent(new Event('change'));

$('.dev-esign').eSign();
$('.vfd-esign').eSign();
selectMulti();
</script>

</body>

</html>
