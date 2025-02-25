<?php
  error_reporting(0);
  include("database.php");
  if (isset($_POST["addProduct-btn"])) {
    $mainProductImage = $_FILES["uploadMainProductImage"]["name"];
   
    $mainStructureFile =  rand(10,1000000)." - ".$mainProductImage;
    move_uploaded_file($_FILES['uploadMainProductImage']['tmp_name'],'upload/'.$mainStructureFile);
    
    $leftProductImage = $_FILES["uploadLeftProductImage"]["name"];

    $leftStructureFile =  rand(10,1000000)." - ".$leftProductImage;
    move_uploaded_file($_FILES['uploadLeftProductImage']['tmp_name'],'upload/'.$leftStructureFile);

    $topProductImage = $_FILES["uploadTopProductImage"]["name"];

    $topStructureFile =  rand(10,1000000)." - ".$topProductImage;
    move_uploaded_file($_FILES['uploadTopProductImage']['tmp_name'],'upload/'.$topStructureFile);

    $frontProductImage = $_FILES["uploadFrontProductImage"]["name"];

    $frontStructureFile =  rand(10,1000000)." - ".$frontProductImage;
    move_uploaded_file($_FILES['uploadFrontProductImage']['tmp_name'],'upload/'.$frontStructureFile);

    $backProductImage = $_FILES["uploadBackProductImage"]["name"];

    $backStructureFile =  rand(10,1000000)." - ".$backProductImage;
    move_uploaded_file($_FILES['uploadBackProductImage']['tmp_name'],'upload/'.$backStructureFile);

    $bottomProductImage = $_FILES["uploadBottomProductImage"]["name"];

    $bottomStructureFile =  rand(10,1000000)." - ".$bottomProductImage;
    move_uploaded_file($_FILES['uploadBottomProductImage']['tmp_name'],'upload/'.$bottomStructureFile);

    $rightProductImage = $_FILES["uploadRightProductImage"]["name"];

    $rightStructureFile =  rand(10,1000000)." - ".$rightProductImage;
    move_uploaded_file($_FILES['uploadRightProductImage']['tmp_name'],'upload/'.$rightStructureFile);

    $productImages = $_FILES["uploadProductImages"]["name"];

    $productImagesStructureFile =  rand(10,1000000)." - ".$productImages;
    move_uploaded_file($_FILES['uploadProductImages']['tmp_name'],'upload/'.$productImagesStructureFile);

    $productCode = $_POST["productCode"];
    $productName = $_POST["productName"];
    $productCategory = $_POST["productCategory"];
    $productCategory_other = $_POST["productCategory_other"];
    $productDescription = $_POST["productDescription"];
    $ingredientList = $_POST["ingredientList"];
    $allergens = $_POST["allergens"];
    $allergen_other = $_POST["allergen_other"];
    $packMatList = $_POST["packMatList"];
    $unitDimensions = $_POST["unitDimensions"];
    $boxDimensions = $_POST["boxDimensions"];
    $palletDimensions = $_POST["palletDimensions"];
    $shelfLife = $_POST["shelfLife"];
    $storeAndHandling = $_POST["storeAndHand"];
    $upcCode = $_POST["upcCode"];
    $gtinNo = $_POST["gtinNo"];
    $leadTime = $_POST["leadTime"];
    $moq = $_POST["moq"];
    $export = $_POST["export"];
    $exportCountry = $_POST["exportCountry"];
    $manufacturedBy = $_POST["manufacturedBy"];
    $manufacturedFrom = $_POST["manufacturedFrom"];
    $distributedBy = $_POST["distributedBy"];
    $countryOfOrigin = $_POST["originCountry"];
    $storageWarehouse = $_POST["warehouse"];
    $lotCodeExplanation = $_POST["lotCodeExplanation"];
    $mockRecallExercise = $_POST["mockRecallExercise"];
    $productTraceExercise = $_POST["productTraceExercise"];

    $foodSafetyPlan = $_FILES["foodSafetyPlan"]["name"];
   
    $foodSafetyPlanStructureFile =  rand(10,1000000)." - ".$foodSafetyPlan;
    move_uploaded_file($_FILES['foodSafetyPlan']['tmp_name'],'upload/'.$foodSafetyPlanStructureFile);

    $formulatorApproval = $_FILES["formulatorApproval"]["name"];

    $formulatorApprovalStructureFile =  rand(10,1000000)." - ".$formulatorApproval;
    move_uploaded_file($_FILES['formulatorApproval']['tmp_name'],'upload/'.$formulatorApprovalStructureFile);

    $finishProductRecallProcedures = $_FILES["finishProductRecallProcedures"]["name"];

    $finishProductRecallProceduresStructureFile =  rand(10,1000000)." - ".$finishProductRecallProcedures;
    move_uploaded_file($_FILES['finishProductRecallProcedures']['tmp_name'],'upload/'.$finishProductRecallProceduresStructureFile);

    $certificateOfAnalysis = $_FILES["certificateOfAnalysis"]["name"];

    $certificateOfAnalysisStructureFile =  rand(10,1000000)." - ".$certificateOfAnalysis;
    move_uploaded_file($_FILES['certificateOfAnalysis']['tmp_name'],'upload/'.$certificateOfAnalysisStructureFile);

    $specifications = $_FILES["specifications"]["name"];

    $specificationsStructureFile =  rand(10,1000000)." - ".$specifications;
    move_uploaded_file($_FILES['specifications']['tmp_name'],'upload/'.$specificationsStructureFile);

    $sds = $_FILES["sds"]["name"];

    $sdsStructureFile =  rand(10,1000000)." - ".$sds;
    move_uploaded_file($_FILES['sds']['tmp_name'],'upload/'.$sdsStructureFile);

    $certificateOfGuarantee = $_FILES["certificateOfGuarantee"]["name"];

    $certificateOfGuaranteeStructureFile =  rand(10,1000000)." - ".$certificateOfGuarantee;
    move_uploaded_file($_FILES['certificateOfGuarantee']['tmp_name'],'upload/'.$certificateOfGuaranteeStructureFile);

    $certificateOfConformance = $_FILES["certificateOfConformance"]["name"];

    $certificateOfConformanceStructureFile =  rand(10,1000000)." - ".$certificateOfConformance;
    move_uploaded_file($_FILES['certificateOfConformance']['tmp_name'],'upload/'.$certificateOfConformanceStructureFile);

    $productLiabilityInsurance = $_FILES["productLiabilityInsurance"]["name"];

    $productLiabilityInsuranceStructureFile =  rand(10,1000000)." - ".$productLiabilityInsurance;
    move_uploaded_file($_FILES['productLiabilityInsurance']['tmp_name'],'upload/'.$productLiabilityInsuranceStructureFile);

    $query = "INSERT INTO products(`mainProductImage`,`leftProductImage`,`topProductImage`, 
    `frontProductImage`,`backProductImage`,`bottomProductImage`,`rightProductImage`,
    `productImages`,`productCode`,`productName`,`productCategory`,`productCategory_other`,`productDescription`,
    `ingredientList`,`allergens`,`allergen_other`,`packMatList`,`unitDimensions`,`boxDimensions`,
    `palletDimensions`,`shelfLife`,`storeAndHandling`,`upcCode`,`gtinNo`,`leadTime`,`moq`,
    `export`,`exportCountry`,`manufacturedBy`,`manufacturedFrom`,`distributedBy`,
    `countryOfOrigin`,`storageWarehouse`,`lotCodeExplanation`,`mockRecallExercise`,
    `productTraceExercise`,`foodSafetyPlan`,`formulatorApproval`,`finishProductRecallProcedures`,
    `certificateOfAnalysis`,`specifications`,`sds`,`certificateOfGuarantee`,
    `certificateOfConformance`,`productLiabilityInsurance`,`productAddedTime`) VALUES ('$mainStructureFile',
    '$leftStructureFile','$topStructureFile','$frontStructureFile','$backStructureFile',
    '$bottomStructureFile','$rightStructureFile','$productImagesStructureFile','$productCode','$productName',
    '$productCategory','$productCategory_other','$productDescription',
    '$ingredientList','$allergens','$allergen_other','$packMatList',
    '$unitDimensions','$boxDimensions','$palletDimensions','$shelfLife','$storeAndHandling',
    '$upcCode','$gtinNo','$leadTime','$moq','$export','$exportCountry','$manufacturedBy',
    '$manufacturedFrom','$distributedBy','$countryOfOrigin','$storageWarehouse',
    '$lotCodeExplanation','$mockRecallExercise','$productTraceExercise','$foodSafetyPlanStructureFile','$formulatorApprovalStructureFile',
    '$finishProductRecallProceduresStructureFile','$certificateOfAnalysisStructureFile','$specificationsStructureFile','$sdsStructureFile',
    '$certificateOfGuaranteeStructureFile','$certificateOfConformanceStructureFile','$productLiabilityInsuranceStructureFile',NOW())";
    $result = mysqli_query($conn, $query);
    header("Location: http://localhost/index/OJT/Product_Page/index.php");
  }
?>
