<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/hskwakr/albamn
 * @since      1.0.0
 *
 * @package    Albamn_Hskwakr
 * @subpackage Albamn_Hskwakr/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="container-sm" style="margin: 1rem 0rem 0rem;">
  <h2 style="margin-bottom: 1rem;">
    Albamn General Settings
  </h2>

  <form method="POST" action="options.php">
    <div class="row">
      <div class="col-sm-4">
        <label>Facebook Graph API Access Token</label>
      </div>

      <div class="col-sm-4">
        <input type="text" class="form-control" />
      </div>
    </div>

    <div style="margin-top: 1rem;">
      <button type="submit" class="btn btn-primary btn-sm">
        Save
      </button>
    </div>
  </form>
</div>
