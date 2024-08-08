<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム　フリー版 最終更新日2014/12/12
#　改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
#
##-----------------------------------------------------------------------------------------------------------------##
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
  date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}
/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
// $site_top = "http://www.ansurs.co.jp/";
$site_top = "/";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください 例 $to = "aa@aa.aa,bb@bb.bb";)
// $to = "info@ansurs.co.jp";
$to = "rinri@toyoame.jp";

//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "メールアドレス";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "ansurs.co.jp";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "ホームページのお問い合わせ";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 1;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "http://www.ansurs.co.jp/thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 1;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲み、複数の場合はカンマで区切ってください。フォーム側と順番を合わせると良いです */
$require = array('問い合わせ種別', '住所', 'お名前姓', 'お名前名', 'ふりがな姓', 'ふりがな名', 'メールアドレス', 'メールアドレス確認用', 'お問い合わせ詳細');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "お問い合わせ、ありがとうございました";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<<TEXT

お問い合わせありがとうございました。
早急にご返信致しますので今しばらくお待ちください。

送信内容は以下になります。

TEXT;


//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 0;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<<FOOTER

──────────────────────
株式会社アンスール
103-0006　東京都中央区日本橋富沢町3-18　サンウォールビル　4階
TEL：03-6222-8295
E-mail:info@ansurs.co.jp
URL: http://www.ansurs.co.jp/
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------

//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//全角英数字→半角変換を行うかどうか。(する=1, しない=0)
$hankaku = 0;

//全角英数字→半角変換を行う項目のname属性の値（name="○○"の「○○」部分）
//※複数の場合にはカンマで区切って下さい。（上記で「1」を指定した場合のみ有効）
//配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$hankaku_array = array('電話番号');


//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）

if (isset($_GET))
  $_GET = sanitize($_GET);//NULLバイト除去//
if (isset($_POST))
  $_POST = sanitize($_POST);//NULLバイト除去//
if (isset($_COOKIE))
  $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
if ($encode == 'SJIS')
  $_POST = sjisReplace($_POST, $encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check, $Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm = '';
$header = '';

if ($requireCheck == 1) {
  $requireResArray = requireCheck($require);//必須チェック実行し返り値を受け取る
  $errm = $requireResArray['errm'];
  $empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if (empty($errm)) {
  foreach ($_POST as $key => $val) {
    if ($val == "confirm_submit")
      $sendmail = 1;
    if ($key == $Email)
      $post_mail = h($val);
    if ($key == $Email && $mail_check == 1 && !empty($val)) {
      if (!checkMail($val)) {
        $errm .= "<p class=\"error_messe\">【" . $key . "】はメールアドレスの形式が正しくありません。</p>\n";
        $empty_flag = 1;
      }
    }
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> 豊　雨　株　式　会　社 </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <link href="css/bootstrap-icons.css" rel="stylesheet">
  <link href="css/top-banner.css?v=1" rel="stylesheet" />

  <!-- jQery -->

  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
  <!-- bootstrap js -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script type="text/javascript" src="js/custom.js?v=1"></script>
  <script type="text/javascript" src="js/common.js?v=1"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->

</head>

<body class="sub_page">
  <div class="load-on" style="display: none;">
    <div id="header">
      <div class="hero_area">

        <div class="hero_bg_box">
          <div class="bg_img_box">
            <img src="images/hero-bg.png" alt="">
          </div>
        </div>

        <!-- header section strats -->
        <header class="header_section">
          <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container ">
              <img id="logo-size" src="img/logo-white.png" alt="">
              <a class="navbar-brand" href="index.html">
                <span class="company_name">
                  豊　雨　株　式　会　社
                </span>
              </a>

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                  <li class="nav-item" id="index">
                    <a class="nav-link" href="index.html">ホーム </a>
                  </li>
                  <li class="nav-item" id="compInfo">
                    <a class="nav-link" href="compInfo.html">会社情報 </a>
                  </li>
                  <li class="nav-item" id="tradeAndWholesale">
                    <a class="nav-link" href="tradeAndWholesale.html"> 貿易・卸売</a>
                  </li>
                  <li class="nav-item" id="humanResourceServices">
                    <a class="nav-link" href="humanResourceServices.html">人材サービス</a>
                  </li>
                  <li class="nav-item" id="socialInitiatives">
                    <a class="nav-link" href="socialInitiatives.html">社会への取組</a>
                  </li>
                  <li class="nav-item active" id="contactUs">
                    <a class="nav-link" href="contactUs.html">お問い合わせ</a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </header>
        <!-- end header section -->
      </div>
    </div>
    <div class="fables-header-contactus fables-after-overlay">
      <div class="fables-header-content">
        <h2 class="fables-page-title fables-second-border-color">お問い合わせ-確認画面</h2>
      </div>
    </div>
    <link href="css/confirmationScreen.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
    <div id="contents" class="inner">

      <div id="contents-in">

        <div id="main">

          <section id="contact-section" class="contact-section">

            <?php

            if (($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1) {

              //差出人に届くメールをセット
              if ($remail == 1) {
                $userBody = mailToUser($_POST, $dsp_name, $remail_text, $mailFooterDsp, $mailSignature, $encode);
                $reheader = userHeader($refrom_name, $to, $encode);
                $re_subject = "=?iso-2022-jp?B?" . base64_encode(mb_convert_encoding($re_subject, "JIS", $encode)) . "?=";
              }
              //管理者宛に届くメールをセット
              $adminBody = mailToAdmin($_POST, $subject, $mailFooterDsp, $mailSignature, $encode, $confirmDsp);
              $header = adminHeader($userMail, $post_mail, $BccMail, $to);
              $subject = "=?iso-2022-jp?B?" . base64_encode(mb_convert_encoding($subject, "JIS", $encode)) . "?=";

              mail($to, $subject, $adminBody, $header);
              if ($remail == 1 && !empty($post_mail))
                mail($post_mail, $re_subject, $userBody, $reheader);
            } else if ($confirmDsp == 1) {

              /*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
              ?>
                <div style="padding: 45px 0"></div>
                <h2 style="font-size: 2rem;font-weight:bold">お問い合わせ-<span style="color: #00bbf0">確認画面</span></h2>
              <?php if ($empty_flag == 1) { ?>
                  <div align="center">
                    <h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
                  <?php echo $errm; ?><br /><br /><input class="button" type="button" value=" 前画面に戻る"
                      onClick="history.back()">
                    <div style="margin-bottom:45px"></div>
                  </div>
              <?php } else { ?>
                  <p>以下の内容で間違いがなければ、「送信する」ボタンを押してください。</p>
                  <form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>" method="POST">
                    <table class="container" class="ta1 mb1em">
                    <?php echo confirmOutput($_POST);//入力内容を表示 ?>
                    </table>
                    <p align="center"><input type="hidden" name="mail_set" value="confirm_submit">
                      <input type="hidden" name="httpReferer" value="<?php echo h($_SERVER['HTTP_REFERER']); ?>">
                      <input class="button" type="submit" value="　送信する　">
                      <input style="background-color:#565e64" class="button" type="button" value="前画面に戻る"
                        onClick="history.back()">
                    </p>
                  </form>
              <?php } ?>
            </div><!-- /formWrap -->
            <!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->

            <!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->

          <?php
              /* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
            }

            if (($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) {

              /* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
              ?>
          <div align="center">
            <?php if ($empty_flag == 1) { ?>
              <h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
              <div style="color:red"><?php echo $errm; ?></div>
              <br /><br /><input type="button" value=" 前画面に戻る" onClick="history.back()">
            </div>
          <?php } else { ?>
            送信ありがとうございました。<br />
            送信は正常に完了しました。<br /><br />
            <a href="<?php echo $site_top; ?>">トップページへ戻る&raquo;</a>
            <?php copyright(); ?>
            <!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
            <?php
            /* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
          }
          ?>
        </div> <?php
            }
            //確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
            else if (($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) {
              if ($empty_flag == 1) { ?>
            <div align="center">
              <h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
              <div style="color:red"><?php echo $errm; ?></div><br /><br /><input type="button" value=" 前画面に戻る "
                onClick="history.back()">
            </div>
          <?php
              } else { ?>
            送信ありがとうございました。<br />
            送信は正常に完了しました。<br /><br />
            <a href="<?php echo $site_top; ?>">トップページへ戻る&raquo;</a>
        <?php // header("Location: ".$thanksPage); 
              }
            }

            ?>
    </div>

    </section>

  </div>
  <!--/main-->

  </div>
  <!--/contents-->


  <!-- footer section -->
  <div id="footer">
    <!-- info section -->

    <section class="info_section layout_padding2">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3 info_col">
            <div class="info_contact">
              <h4>
                お問い合わせ
              </h4>
              <div class="contact_link_box">
              <a href="https://www.google.com/maps/place/China,+Shang+Hai+Shi,+Pu+Dong+Xin+Qu,+%E5%8D%8E%E7%94%B3%E8%B7%AF180%E5%8F%B7+%E9%82%AE%E6%94%BF%E7%BC%96%E7%A0%81:+200137/@31.3409399,121.5962991,17z/data=!3m1!4b1!4m10!1m2!2m1!1z6Ieq55Sx6LS45piT6K-V6aqM5Yy65Y2O55Sz6LevMTgw5Y-3MeW5ouWFreWxgg!3m6!1s0x35b27534b7c83483:0x8112f20e8f8d94ef!8m2!3d31.34094!4d121.60117!15sCi7oh6rnlLHotLjmmJPor5XpqozljLrljY7nlLPot68xODDlj7cx5bmi5YWt5bGCkgEQZ2VvY29kZWRfYWRkcmVzc-ABAA!16s%2Fg%2F11dzn0zthb?entry=ttu"
              target="_blank">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  <span>
                    中国(上海)自由贸易试验区华申路180号1幢六层6020室
                  </span>
                </a>
                <div class="call">
                  <i class="fa fa-phone" aria-hidden="true"></i>
                  <span>
                    Call 021-58367307
                  </span>
                </div>
              </div>
            </div>
            <div class="info_social">
              <a target="_blank"><img src="img/lineqr.jpg" alt=""></a>
              <a target="_blank"><img src="img/wechatqr.jpg" alt=""></a>

              <!-- <a target="_blank"><img src="img/line.jpg" alt=""></a> -->
              <a href="https://www.facebook.com/profile.php?id=100061816236948">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a href="https://mobile.twitter.com/toyoame">
                  <img class="twitter-logo" src="img/twitter-x-logo1.png" alt="" onmouseover="this.src='img/twitter-x-logo2.png';" onmouseout="this.src='img/twitter-x-logo1.png';">
                </a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 info_col">
            <div class="info_detail">
              <h4>
                &nbsp;
              </h4>
                龙绩贸易(上海)有限公司<br>
                中国(上海)自由贸易试验区华申路180号1幢六层6020室<br>
                <div class="call">
                  <i class="fa fa-phone" aria-hidden="true"></i>
                  <span>
                    Call 052-908-6760
                  </span>
                </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-2 mx-auto info_col">
            <div class="info_link_box">
              <h4>
                メニュー
              </h4>
              <div class="info_links">
                <a class="active" href="index.html">
                  ホーム
                </a>
                <a class="" href="compInfo.html">
                  会社情報
                </a>
                <a class="" href="tradeAndWholesale.html">
                  貿易・卸売
                </a>
                <a class="" href="humanResourceServices.html">
                  人材サービス
                </a>
                <a class="" href="socialInitiatives.html">
                  社会への取組
                </a>
                <a class="" href="contactUs.html">
                  お問い合わせ
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- end info section -->

    <!-- footer section -->
    <section class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span><strong>豊雨株式会社サイト</strong>. All Rights Reserved
        </p>
      </div>
    </section>
    <!-- footer section -->

    <!-- The "UP" button -->
    <button onclick="scrollToTop()" id="scrollTopBtn" title="Go to top" class="btn">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
          d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5" />
      </svg>
    </button>
  </div>

  <!-- footer section -->
  <script>
    if (OCwindowWidth() <= 900) {
      open_close("menubar_hdr", "menubar-s");
    }
  </script>
  </div>
  <div id="loader-bg">
    <div id="loader">
      <img src="img/load.svg" alt="Now Loading...">
    </div>
  </div>
</body>

</html>

<?php

// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str)
{
  $mailaddress_array = explode('@', $str);
  if (preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) == 2) {
    return true;
  } else {
    return false;
  }
}
function h($string)
{
  global $encode;
  return htmlspecialchars($string, ENT_QUOTES, $encode);
}
function sanitize($arr)
{
  if (is_array($arr)) {
    return array_map('sanitize', $arr);
  }
  return str_replace("\0", "", $arr);
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr, $encode)
{
  foreach ($arr as $key => $val) {
    $key = str_replace('＼', 'ー', $key);
    $resArray[$key] = $val;
  }
  return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr)
{
  global $hankaku, $hankaku_array;
  $resArray = '';
  foreach ($arr as $key => $val) {
    $out = '';
    if (is_array($val)) {
      foreach ($val as $key02 => $item) {
        //連結項目の処理
        if (is_array($item)) {
          $out .= connect2val($item);
        } else {
          $out .= $item . ', ';
        }
      }
      $out = rtrim($out, ', ');

    } else {
      $out = $val;
    }//チェックボックス（配列）追記ここまで
    // if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
    $out = stripslashes($out);

    //全角→半角変換
    if ($hankaku == 1) {
      $out = zenkaku2hankaku($key, $out, $hankaku_array);
    }
    if ($out != "confirm_submit" && $key != "httpReferer") {
      $resArray .= "【 " . h($key) . " 】 " . h($out) . "\n";
    }
  }
  return $resArray;
}
//確認画面の入力内容出力用関数
function confirmOutput($arr)
{
  global $hankaku, $hankaku_array;
  $html = '';
  foreach ($arr as $key => $val) {
    $out = '';
    if (is_array($val)) {
      foreach ($val as $key02 => $item) {
        //連結項目の処理
        if (is_array($item)) {
          $out .= connect2val($item);
        } else {
          $out .= $item . ', ';
        }
      }
      $out = rtrim($out, ', ');

    } else {
      $out = $val;
    }//チェックボックス（配列）追記ここまで
    // if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
    $out = stripslashes($out);
    $out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
    $key = h($key);

    //全角→半角変換
    if ($hankaku == 1) {
      $out = zenkaku2hankaku($key, $out, $hankaku_array);
    }

    $html .= "<tr><th>" . $key . "</th><td>" . $out;
    $html .= '<input type="hidden" name="' . $key . '" value="' . str_replace(array("<br />", "<br>"), "", $out) . '" />';
    $html .= "</td></tr>\n";
  }
  return $html;
}

//全角→半角変換
function zenkaku2hankaku($key, $out, $hankaku_array)
{
  global $encode;
  if (is_array($hankaku_array) && function_exists('mb_convert_kana')) {
    foreach ($hankaku_array as $hankaku_array_val) {
      if ($key == $hankaku_array_val) {
        $out = mb_convert_kana($out, 'a', $encode);
      }
    }
  }
  return $out;
}
//配列連結の処理
function connect2val($arr)
{
  $out = '';
  foreach ($arr as $key => $val) {
    if ($key === 0 || $val == '') {//配列が未記入（0）、または内容が空のの場合には連結文字を付加しない（型まで調べる必要あり）
      $key = '';
    } elseif (strpos($key, "円") !== false && $val != '' && preg_match("/^[0-9]+$/", $val)) {
      $val = number_format($val);//金額の場合には3桁ごとにカンマを追加
    }
    $out .= $val . $key;
  }
  return $out;
}

//管理者宛送信メールヘッダ
function adminHeader($userMail, $post_mail, $BccMail, $to)
{
  $header = '';
  if ($userMail == 1 && !empty($post_mail)) {
    $header = "From: $post_mail\n";
    if ($BccMail != '') {
      $header .= "Bcc: $BccMail\n";
    }
    $header .= "Reply-To: " . $post_mail . "\n";
  } else {
    if ($BccMail != '') {
      $header = "Bcc: $BccMail\n";
    }
    $header .= "Reply-To: " . $to . "\n";
  }
  $header .= "Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/" . phpversion();
  return $header;
}
//管理者宛送信メールボディ
function mailToAdmin($arr, $subject, $mailFooterDsp, $mailSignature, $encode, $confirmDsp)
{
  $adminBody = "「" . $subject . "」からメールが届きました\n\n";
  $adminBody .= "＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
  $adminBody .= postToMail($arr);//POSTデータを関数からセット
  $adminBody .= "\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
  $adminBody .= "送信された日時：" . date("Y/m/d (D) H:i:s", time()) . "\n";
  $adminBody .= "送信者のIPアドレス：" . @$_SERVER["REMOTE_ADDR"] . "\n";
  $adminBody .= "送信者のホスト名：" . getHostByAddr(getenv('REMOTE_ADDR')) . "\n";
  if ($confirmDsp != 1) {
    $adminBody .= "問い合わせのページURL：" . @$_SERVER['HTTP_REFERER'] . "\n";
  } else {
    $adminBody .= "問い合わせのページURL：" . @$arr['httpReferer'] . "\n";
  }
  if ($mailFooterDsp == 1)
    $adminBody .= $mailSignature;
  return mb_convert_encoding($adminBody, "JIS", $encode);
}

//ユーザ宛送信メールヘッダ
function userHeader($refrom_name, $to, $encode)
{
  $reheader = "From: ";
  if (!empty($refrom_name)) {
    $default_internal_encode = mb_internal_encoding();
    if ($default_internal_encode != $encode) {
      mb_internal_encoding($encode);
    }
    $reheader .= mb_encode_mimeheader($refrom_name) . " <" . $to . ">\nReply-To: " . $to;
  } else {
    $reheader .= "$to\nReply-To: " . $to;
  }
  $reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/" . phpversion();
  return $reheader;
}
//ユーザ宛送信メールボディ
function mailToUser($arr, $dsp_name, $remail_text, $mailFooterDsp, $mailSignature, $encode)
{
  $userBody = '';
  if (isset($arr[$dsp_name]))
    $userBody = h($arr[$dsp_name]) . " 様\n";
  $userBody .= $remail_text;
  $userBody .= "\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
  $userBody .= postToMail($arr);//POSTデータを関数からセット
  $userBody .= "\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
  $userBody .= "送信日時：" . date("Y/m/d (D) H:i:s", time()) . "\n";
  if ($mailFooterDsp == 1)
    $userBody .= $mailSignature;
  return mb_convert_encoding($userBody, "JIS", $encode);
}
//必須チェック関数
function requireCheck($require)
{
  $res['errm'] = '';
  $res['empty_flag'] = 0;
  foreach ($require as $requireVal) {
    $existsFalg = '';
    foreach ($_POST as $key => $val) {
      if ($key == $requireVal) {

        //連結指定の項目（配列）のための必須チェック
        if (is_array($val)) {
          $connectEmpty = 0;
          foreach ($val as $kk => $vv) {
            if (is_array($vv)) {
              foreach ($vv as $kk02 => $vv02) {
                if ($vv02 == '') {
                  $connectEmpty++;
                }
              }
            }

          }
          if ($connectEmpty > 0) {
            $res['errm'] .= "<p class=\"error_messe\">【" . h($key) . "】は必須項目です。</p>\n";
            $res['empty_flag'] = 1;
          }
        }
        //デフォルト必須チェック
        elseif ($val == '') {
          $res['errm'] .= "<p class=\"error_messe\">【" . h($key) . "】は必須項目です。</p>\n";
          $res['empty_flag'] = 1;
        }

        $existsFalg = 1;
        break;
      }

    }
    if ($existsFalg != 1) {
      $res['errm'] .= "<p class=\"error_messe\">【" . $requireVal . "】が未選択です。</p>\n";
      $res['empty_flag'] = 1;
    }
  }

  return $res;
}
//リファラチェック
function refererCheck($Referer_check, $Referer_check_domain)
{
  if ($Referer_check == 1 && !empty($Referer_check_domain)) {
    if (strpos($_SERVER['HTTP_REFERER'], $Referer_check_domain) === false) {
      return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
    }
  }
}
function copyright()
{
  echo '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://www.php-factory.net/" target="_blank">- PHP工房 -</a>';
}
//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>