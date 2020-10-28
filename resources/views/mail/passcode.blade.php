<!DOCTYPE html>
<html lang="zxx" class="js">
  <head>
    <base href="../../" />
    <meta charset="utf-8" />
    <meta name="author" content="Health A Vision" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="@@page-discription" />
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png" />
    <!-- Page Title  -->
    <title>Email Passcode | Health A Vision Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="https://www.healthavision.com/hav/assets/css/styles.css?ver=1.4.0" />
    <link
      id="skin-default"
      rel="stylesheet"
      href="https://www.healthavision.com/hav/assets/css/theme.css?ver=1.4.0"
    />
    <style>
    body {
      display: flex;
      justify-content: center;
    }
    </style>
  </head>

  <body class="nk-body npc-subscription ui-clean">
    <div class="nk-app-root">
      <div class="nk-main">
        <div class="nk-wrap">
          <div class="nk-content">
            <div class="container wide-sm">
              <div class="nk-content-inner">
                <div class="nk-content-body">
                  <div class="nk-content-wrap">
                    <div
                      class="nk-block-head nk-block-head-lg wide-sm m-auto text-center"
                    >
                      <div class="nk-block-head-sub" style="text-align: center;">
                        <img class="text-soft" width="300" src="https://www.healthavision.com/hav/images/logo-hav2x.png" />
    
                      </div>
                      <div class="nk-block-head-content"  style="text-align: center;">
                        <h2 class="nk-block-title fw-normal">
                          Email Verification Passcode
                        </h2>
                        <br/>
                        <br/>
                        <div class="nk-block-des"  style="text-align: center;">
                          <p>
                            Your passcode for Email Verification is <h2>{{ $passcode }}</h2>. This code is valid for 2 hours.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="nk-footer">
          <div class="container wide-xl">
            <div class="nk-footer-wrap g-2">
              <div class="nk-footer-copyright"  style="text-align: center;">
              <br/><br/>
                &copy; 2020 Health A Vision.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
