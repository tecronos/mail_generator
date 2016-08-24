<?php
// Start output buffering
ob_start();

/*
 * CONFIGURATION SECMENT
 * ---------------------------------/
*/

// Header JSON data --> PHP 
$json_data = file_get_contents("configuration.json");
$configuration_data = json_decode($json_data);

// Data section
$template_list = $configuration_data->template_list;

$comment_line = "\n <!-- ============================ --> \n";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $template_title; ?> </title>

    <style type="text/css">
      <?php
      // Core styles
      include 'style/core.css';
      echo "\n";

      // style generator
        foreach ($template_list as $temp) {
          if($temp->style!=""){
            if($temp->active && file_exists('style/'.$temp->style)) {
                include 'style/'.$temp->style;
                echo "\n";
            }
          }
        }
      ?>
    </style>

  </head>

  <body bgcolor="#e5e5e5" style="background:#e5e5e5;color:#313131;margin:0;">

    <!-- PREVIEW TEXT -->
    <font style="line-height:0;font-size:0;padding:0;">
      <?php echo $template_preheader; ?>
    </font>
    <!-- END PREVIEW TEXT -->

    <table width="100%" border="0" bgcolor="#e5e5e5" cellpadding="0" cellspacing="0"  style="border-spacing:0px;border:0;">
      <tbody>
        <tr>
          <td width="50%" style="width:50%"><a style="color:inherit;text-decoration:none"></a></td>
          <td width="700" style="border-collapse:collapse;">

            <!-- CONTENT TABLE -->
            <table class="content-table" width="700" border="0" cellpadding="0" cellspacing="0"  style="border-spacing:0;border:0;">
              <tbody>
                <tr class="no-show-mobile" bgcolor="#e5e5e5" style="height:18px"><td><a style="color:inherit;text-decoration:none"></a></td></tr>
                <?php
                // Content generator
                $count_section = 0;
                foreach ($template_list as $temp) {
                  echo $comment_line;
                  echo '<!-- SECTION '.$count_section.'. '.$temp->section_name.' -->';
                  echo $comment_line;
                  if($temp->active && file_exists('section/'.$temp->template)) {
                    include 'section/'.$temp->template;
                  }
                  else if($temp->active) {
                    echo "<tr><td>Section {$count_section} does not exist please add it or set it false</td></tr>";
                  }
                  echo $comment_line;
                  echo '<!-- END OF SECTION '.$count_section.'. '.$temp->section_name.' -->';
                  echo $comment_line;
                  $count_section++;
                }
                ?>
                <tr class="no-show-mobile" style="height:18px" bgcolor="#e5e5e5"><td><a style="color:inherit;text-decoration:none"></a></td></tr>
              </tbody>
            </table>
            <!-- END CONTENT TABLE -->

          </td>
          <td width="50%" style="width: 50%"><a style="color:inherit;text-decoration:none"></a></td>
        </tr>
      </tbody>
    </table>
  </body>
</html>

<?php
file_put_contents('template.html', ob_get_contents());
// end buffering and displaying page
ob_end_flush();
?>

<script type="text/javascript">
  window.location = "template.html";
</script>'