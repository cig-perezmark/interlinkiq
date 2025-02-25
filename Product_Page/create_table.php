<?php
  include("connection.php");
  $query = "CREATE TABLE products(ID int AUTO_INCREMENT,PRIMARY KEY (ID),mainProductImage TEXT,
  leftProductImage TEXT,topProductImage TEXT,frontProductImage TEXT,backProductImage TEXT,
  bottomProductImage TEXT,rightProductImage TEXT,productImages TEXT,productCode VARCHAR(256),
  productName VARCHAR(256),productCategory VARCHAR(32),productCategory_other VARCHAR(256),productDescription VARCHAR(2048),
  ingredientList VARCHAR(256),allergens VARCHAR(256),allergen_other VARCHAR(256),packMatList VARCHAR(215),
  unitDimensions VARCHAR(256),boxDimensions VARCHAR(256),palletDimensions VARCHAR(256),shelfLife VARCHAR(256),
  storeAndHandling VARCHAR(256),upcCode VARCHAR(256),gtinNo VARCHAR(256),leadTime VARCHAR(256),moq VARCHAR(256),
  export VARCHAR(256),exportCountry VARCHAR(256),manufacturedBy VARCHAR(256),manufacturedFrom VARCHAR(256),
  distributedBy VARCHAR(256),countryOfOrigin VARCHAR(256),storageWarehouse VARCHAR(256),lotCodeExplanation VARCHAR(1024),
  mockRecallExercise date,productTraceExercise date,foodSafetyPlan TEXT,formulatorApproval TEXT,finishProductRecallProcedures TEXT,
  certificateOfAnalysis TEXT,specifications TEXT,sds TEXT,certificateOfGuarantee TEXT,
  certificateOfConformance TEXT,productLiabilityInsurance TEXT,productAddedTime VARCHAR(128))";
  $result = mysqli_query($con, $query);
  echo "Table Created!";
?>
