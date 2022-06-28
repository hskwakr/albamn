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
<p class="albamn-fs">
  Instagramの投稿をWordPressで利用できるようにするプラグインです。
</p>

<h5>使い方</h5>

<div class="albamn-mt">
  <ol class="albamn-px">
    <li>
      <p class="albamn-fs">
        Instagram Graph APIのアクセストークンをプラグインのSettingsページのAccess tokenの欄に設定してください。
        <br>
        <a href="https://developers.facebook.com/docs/instagram-api/getting-started">
          Instagram Graph APIについて
        </a>
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        プラグインのImporterページでハッシュタグに基づいてInstagramの投稿一覧を取得できます。<code class="albamn-code">＃</code>は必要ありません。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        プラグインのEditorページで取得した投稿一覧を編集できます。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        Wordpressの投稿ページで<code class="albamn-code">[albamn-ig]</code>というショートコードでInstagramの投稿一覧を記事に埋め込むことができます。
      </p>
    </li>
  </ol>
</div>
