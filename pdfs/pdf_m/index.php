<?php

	require_once __DIR__ . '/vendor/autoload.php';

	$mpdf = new \Mpdf\Mpdf();

	$html = '<html>
    	<head>
    		<title>test</title>
    	</head>
    	<body>
    		<table>
    			<tr>
    				<td colspan="2">all</td>
    			</tr>
    			<tr>
    				<td>1</td>
    				<td>2</td>
    			</tr>
    		</table>
    	</body>
    </html>';
    
	$mpdf->WriteHTML($html);
	$mpdf->Output();

?>
