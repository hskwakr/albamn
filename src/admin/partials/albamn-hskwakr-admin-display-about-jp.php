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

<h5>準備</h5>

<div class="albamn-mt">
  <ol class="albamn-px">
    <li>
      <p class="albamn-fs">
        このプラグインフォルダ内のmediasフォルダに書き込み権限を付与してください。
      </p>
    </li>
  </ol>
</div>

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

<h5>アクセストークンについて</h5>

<div class="albamn-mt">
  <p class="albamn-fs">
    Instagram Graph APIに利用するアクセストークンを取得するための方法について説明します。
  </p>

  <ol class="albamn-px">
    <li>
      <p class="albamn-fs">
        Instagram Business / Creatorアカウントを用意する。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        Facebook Pageを用意してInstagramアカウントと連携する。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        Meta for developersにFacebookアカウントでログインする。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        アプリを作る。（Businessを選択）
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        App Dashboardの画面上部のToolsからGraph Api Explorerに移動する。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        Permissionsの欄のAdd a permissionから<code class="albamn-code">pages_show_list</code>と<code class="albamn-code">instagram_basic</code>を追加してGenerate Access Tokenを選択
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        認証ウィンドウで使用するInstagramアカウントなどの設定をする。
      </p>
    </li>
  </ol>

  <p class="albamn-fs">
    この時点でアクセストークンが機能するか試してみることをお勧めします。
    <br>
    エラーがなく動作する場合、アクセストークンの有効期限の延長をお勧めします。（延長しない場合の有効期限は１時間程です）
  </p>

  <p class="albamn-fs">
  </p>

  <ol class="albamn-px">
    <li>
      <p class="albamn-fs">
        App Dashboardの画面上部のToolsからAccess token debuggerに移動する。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        テキストフィールドにアクセストークンをコピーペーストしてDebugボタンを選択。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        Infoの表の中のExpires（有効期限を意味する項目）を確認する。
        <br>
        表の下にExtend Access Tokenというボタンがある場合、有効期限の延長ができる。
      </p>
    </li>

    <li>
      <p class="albamn-fs">
        ボタンを選択すると下に新しいアクセストークンが表示される。
        <br>
        右側にあるDebugボタンで新しいアクセストークンの情報を確認できる。
      </p>
    </li>
  </ol>
</div>
