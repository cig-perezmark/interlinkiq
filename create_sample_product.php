<?php
  include("database.php");
  
  $mainProductImage = "";
  $leftProductImage = "";
  $topProductImage = "";
  $frontProductImage = "";
  $backProductImage = "";
  $bottomProductImage = "";
  $rightProductImage = "";
  $productImages = "";
  $productCode = "Sample Product Code";
  $productName = "Sample Product Name";
  $productCategory = "Food";
  $productCategory_other = "";
  $productDescription = "Sample Product Description";
  $ingredientList = "Sample Ingredient's List";
  $allergens = "";
  $allergen_other = "";
  $packMatList = "Sample Package Material List";
  $unitDimensions = "12x12x12 in";
  $boxDimensions = "120x120x120 in";
  $palletDimensions = "120x120 in";
  $shelfLife = "Sample Shelf Life";
  $storeAndHandling = "Sample Storage and Handling";
  $upcCode = "Sample UPC Code";
  $gtinNo = "Sample GTIN Number";
  $leadTime = "Sample Lead Time";
  $moq = "Sample MOQ";
  $export = "";
  $exportCountry = "";
  $manufacturedBy = "Sample Manufactured By";
  $manufacturedFrom = "Sample Manufactured From";
  $distributedBy = "Sample Distributed By";
  $countryOfOrigin = "Sample Country of Origin";
  $storageWarehouse = "Sample Storage Warehouse";
  $lotCodeExplanation = "Sample Lot Code Explanation";
  $mockRecallExercise = "";
  $productTraceExercise = "";
  $foodSafetyPlan = "";
  $finishProductRecallProcedures = "";
  $certificateOfAnalysis = "";
  $specifications = "";
  $sds = "";
  $certificateOfGuarantee = "";
  $certificateOfConformance = "";
  $productLiabilityInsurance = "";
  $productAddedTimeLong = "";
  $productAddedTimeDay = "";
  $productAddedTimeTime = "";
  $query = "INSERT INTO products(`mainProductImage`,`leftProductImage`,`topProductImage`, 
  `frontProductImage`,`backProductImage`,`bottomProductImage`,`rightProductImage`,
  `productImages`,`productCode`,`productName`,`productCategory`,`productCategory_other`,
  `productDescription`,`ingredientList`,`allergens`,`allergen_other`,`packMatList`,
  `unitDimensions`,`boxDimensions`,`palletDimensions`,`shelfLife`,`storeAndHandling`,
  `upcCode`,`gtinNo`,`leadTime`,`moq`,`export`,`exportCountry`,`manufacturedBy`,
  `manufacturedFrom`,`distributedBy`,`countryOfOrigin`,`storageWarehouse`,
  `lotCodeExplanation`,`mockRecallExercise`,`productTraceExercise`,`foodSafetyPlan`,
  `finishProductRecallProcedures`,`certificateOfAnalysis`,`specifications`,`sds`,
  `certificateOfGuarantee`,`certificateOfConformance`,`productLiabilityInsurance`,
  `productAddedTimeLong`,`productAddedTimeDay`,`productAddedTimeTime`) VALUES 
  ('$mainProductImage','$leftProductImage','$topProductImage','$frontProductImage',
  '$backProductImage','$bottomProductImage','$rightProductImage','$productImages',
  '$productCode','$productName','$productCategory','$productCategory_other',
  '$productDescription','$ingredientList','$allergens','$allergen_other','$packMatList',
  '$unitDimensions','$boxDimensions','$palletDimensions','$shelfLife',
  '$storeAndHandling','$upcCode','$gtinNo','$leadTime','$moq','$export',
  '$exportCountry','$manufacturedBy','$manufacturedFrom','$distributedBy',
  '$countryOfOrigin','$storageWarehouse','$lotCodeExplanation','$mockRecallExercise',
  '$productTraceExercise','$foodSafetyPlan','$finishProductRecallProcedures',
  '$certificateOfAnalysis','$specifications','$sds','$certificateOfGuarantee',
  '$certificateOfConformance','$productLiabilityInsurance','$productAddedTimeLong',
  '$productAddedTimeDay','$productAddedTimeTime')";
  $result = mysqli_query($con, $query);
  echo "Sample Product Created!";
?>
