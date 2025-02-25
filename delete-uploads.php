<?php 

if(!isset($_COOKIE['ID'])) {
    exit('Please login first');
}
    
// include_once ('database_iiq.php');

// if(!$conn->query)

date_default_timezone_set('America/Chicago');

$paths = $_POST['paths'] ?? null;

if($paths) {
    $result = "";
    $logResult = "";
    $paths = explode("\r\n", $paths);
    $libDir = "./uploads/library";
    
    $logFile = fopen('delete-uploads-log.txt', 'a');

    foreach($paths as $path) {
        if(empty($path)) {
            continue;
        }
        
        $path = urldecode($path);
        $refinedPath = str_replace("https://interlinkiq.com/uploads/library", $libDir, $path);
        
        if(file_exists($refinedPath)) {
            
            if (unlink($refinedPath)) {
                $result .= 'COMPLETED';
                $logResult .= $path . ' - COMPLETED';
            } else {
                $result .= $path . ' - unable to delete the file';
                $logResult .= $path . ' - unable to delete the file';
            }
            
           
        } else {
            $result .= $path . ' - NOT FOUND';
            $logResult .= $path . ' - NOT FOUND';
        }
        
        $result .= "\r\n";
        $logResult .= "\r\n";
    }
    
    echo $result;
    
    fwrite($logFile, "\n\n" . date('Y-m-d H:i:s') . " - ID: ".$_COOKIE['ID']." \n" . $logResult);
    fclose($logFile);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  <title>Delete files from uploads/library folder</title>
  <style>
  textarea {
    width: 100%;
    resize: vertical;
    min-height: 8rem;
  }

  button {
    padding: .5rem 2rem;
  }

  button[type=submit] {
    display: none;
  }

  #howto .content {
    display: none;
  }

  #howto:has(input:checked) .content {
    display: block;
  }
  </style>
</head>

<body>
  <div id="howto">
    <a href="javascript:void(0)">
      <label>
        <input type="checkbox"
               style="display: none;">
        How to use:
      </label>
    </a>
    <div class="content">
      <ol>
        <li>Open the <strong title="Link not provided for access protection :)">CIG-Video Monitoring</strong>
          spreadsheet
          file</li>
        <li>Copy the link(s) from the <strong>IIQ Link (Old)</strong> column (currently at column D)
          <br>
          <small>Note: You can copy multiple cells at once</small>
        </li>
        <li>Paste the copied link(s) in the <strong>File input(s)</strong> box below</li>
        <li>Once ready, click the <strong>Start delete</strong> button</li>
        <li>Successful deletion is <strong>only determined by "COMPLETED" message</strong> in a line</li>
        <li>Otherwise, the attempt is not a success</li>
      </ol>
      <p><strong>Important note</strong> <br>
        To double check if the file has been successfully deleted, you may try to paste its link in your browser address
        bar or visit the link in the spreadsheet. If a video/file is played, then it is not yet deleted. <br>
        Some link(s) would result to "NOT FOUND" (in the results box) but when you try to open it (from the
        spreadsheet), it is still
        playable,
        that
        is because the pasted link is not complete/valid. Try replacing it with the original url of the playable tab
        (from
        the address bar) you have
        opened recently.
      </p>
    </div>
  </div>
  <br>
  <form id="form">
    File input(s):
    <div>
      <textarea name="paths" placeholder="Paste absolute file path (multiple input should be separated with newlines) here..." required rows="10"></textarea>
    </div>
    <div>
      <button type="submit" id="submit"></button>
      <button type="button" id="btn">Start delete</button>
    </div>
    <br> Results:
    <div>
      <textarea readonly id="result" placeholder="Results are displayed here..." rows="20"></textarea>
    </div>
    <div>
      <button type="button" id="reset">Reset</button>
    </div>
  </form>
  <script>
  const btn = document.getElementById('btn');
  const submitBtn = document.getElementById('submit');
  const form = document.getElementById('form');
  const result = document.getElementById('result');
  const resetBtn = document.getElementById('reset');

  btn.addEventListener('click', function() {
    submitBtn.click();
  });

  resetBtn.addEventListener('click', function() {
    result.value = '';
    document.querySelector('[name="paths"]').value = '';
  });

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    resetBtn.disabled = true;
    btn.disabled = true;
    result.value = "";
    result.placeholder = "Processing...";
    if (confirm('Please confirm')) {
        
      fetch('delete-uploads.php', {
        method: 'POST',
        body: formData
      }).then(r => r.text()).then(data => {
        resetBtn.disabled = false;
        btn.disabled = false;
        result.value = data;
        
        result.placeholder = "Results are displayed here...";
      })
    }
  });
  </script>
</body>

</html>
