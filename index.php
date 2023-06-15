<?php
echo "<style>";
require_once ("css/styles.css");
echo "</style>";

define("NOAUTH",true);

$defaultPage = "<span class='alignment'>
                <div class='information'>
                    <h1 class='title_h1'>Clinician Study App (CSA)</h1>
                    <h3 class='title_h3'>What is the Clinician Study App (CSA)?</h3>
                    <div class='body_text'>
                        <p>
                            The CSA is a  web-based ‘study app’ that can be tailored to any study to make it easy for clinical staff and/or key study personnel to refer patients to the local study contact for study eligibility screening. As an electronic replacement to the traditional Study Information Card, each site receives a unique CSA link that can be saved to a mobile device (phone/tablet) for reference when patients might be eligible for the study.
                        </p>
                        <p>
                            The CSA provides <strong>quick</strong> and <strong>convenient access</strong> to information about the study (e.g., eligibility criteria), as well as contact information for the study team. Because the CSA is electronic, when the study information on the CSA is updated or changed it becomes immediately available to all users.
                        </p>
                    </div>
                </div>
                <div class='banner'>
                    <img width='75%' src='images/CSA%20Example.jpg'/>
                </div>
                <div class='information'>
                    <div class='body_text'>
                        Typical Information Provided on a CSA:
                        <ul>
                            <li>Brief description of study</li>
                            <li>Eligibility (Inclusion/Exclusion Criteria)</li>
                            <li>Visit Schedule</li>
                            <li>Site-specific study contacts</li>
                            <li>Study visit procedures</li>
                        </ul>
                    </div>
                </div>
                <div class='information'>
                    <h3 class='title_h3'>CSA Workflow</h3>
                    <div class='banner'>
                        <img width='75%' src='images/CSA%20Workflow.jpg'/>
                    </div>
                    <h3 class='title_h3'>Requesting Support: Trial Innovation Network</h3>
                    <div class='body_text'>
                        <ol>
                            <li>PI/Study Teams submit proposal through the TIN.</li>
                            <li>Select any Recruitment Innovation Center Resource offering.</li>
                            <li>Participate in an initial consultation – CSA will be considered during consultation with RIC project manager.</li>
                        </ol>
                        <strong>Click <a href='https://trialinnovationnetwork.org/elements/trial-innovation-network-proposal-process/'>here</a> to submit a TIN proposal.</strong>
                    </div>
                </div>
            </span>";
?>

<!doctype html>
<html lang='en'>
<head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-status-bar-style' content='default'>
    <meta name='mobile-web-app-capable' content='yes'>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js' integrity='sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49' crossorigin='anonymous'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js' integrity='sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy' crossorigin='anonymous'></script>

    <!-- Bootstrap CSS -->
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>

    <style>
        #content{
            max-width: 800px;
            padding: 20px;
            margin: auto;
        }

        table th,
        table td{
            border: 1px solid #dfdfdf;
            padding: 2px 5px;
        }

        .navbar-brand{
            margin-top: 4px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<?php
$studyName = $siteNumber = $pageName = "";

    define("ENVIRONMENT",(isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] == '/app001/www/mystudyinfo' ? "PROD" : 'DEV'));

    if (ENVIRONMENT == "PROD") {
        define("BASE_URL","https://mystudyinfo.org/");
        define("MODULE_PROJECT",148706);
        define("AJAX_URL","https://redcap.vanderbilt.edu/external_modules/?prefix=study-sites&page=ajax&pid=".MODULE_PROJECT."&NOAUTH");
    } elseif (ENVIRONMENT == "DEV") {
        require_once("../redcap_test/redcap_connect.php");
        define("BASE_URL","https://localhost/mystudyinfo/");
        define("MODULE_PROJECT",138);
        define("AJAX_URL","https://localhost/redcap_test/redcap_v13.7.1/ExternalModules/?prefix=study-sites-module&page=ajax&pid=".MODULE_PROJECT."&NOAUTH");
    } else {
        // Some environment error has occurred
    }

    if (isset($_GET['study-name']) && isset($_GET['site-number']) && isset($_GET['page-name'])) {
        $studyName = htmlspecialchars($_GET['study-name']);
        $siteNumber = htmlspecialchars($_GET['site-number']);
        $pageName = htmlspecialchars($_GET['page-name']);
    }

    try {
        $_GET['NOAUTH'] = true;
        $_GET['pid'] = MODULE_PROJECT;

        echo "<script type='text/javascript'>
            function logPageLoad(study,site,page,url) {
                var browserName = getBrowserString();
                console.log('Running log of page load '+page);
                const xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        //console.log(this.responseText);
                    }
                  };
                xhttp.open('GET', '".AJAX_URL."&action=log&pid=".MODULE_PROJECT."&study_name='+study+'&site_number='+site+'&page_name='+page+'&browser='+browserName+'&url='+url);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send();
                
                window.history.replaceState(null,null,url);
            }
            function getBrowserString() {
                return window.navigator.userAgent.toLowerCase();
            }
            
            
            function generateStudyPage(rowSelector) {
                console.log('Loading study page');
                const xhttp = new XMLHttpRequest();
                let pageHTML = ".json_encode($defaultPage).";
                  xhttp.onreadystatechange = function() {
                    let row = document.getElementById(rowSelector);
                    if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                      if (this.responseText != '') {
                        row.innerHTML = this.responseText;
                        let loadingLinks = new testBuild;
                      }
                      else {
                        row.innerHTML = pageHTML;
                        logPageLoad('','','','".BASE_URL."');
                      }
                    }
                  };
                xhttp.open('GET', '".AJAX_URL."&action=content&pid=".MODULE_PROJECT."&study_name=$studyName&site_number=$siteNumber&page_name=$pageName');
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send();
            }
        
              class testBuild {
                constructor() {
                  const links = this.getLinks()
                  //console.log(links);
                  links.click(e => {
                    const link = $(e.target)
                    this.loadPage(link)
                    logPageLoad('$studyName','$siteNumber',link[0].dataset.pageid,'".BASE_URL.$studyName."/".$siteNumber."/'+link[0].dataset.pageid);
                    $('#navbarSupportedContent').removeClass('show')
                  })
        
                  this.loadPage($(links[".(is_numeric($pageName) && $pageName > 0 ? $pageName - 1 : 0)."]))
                  logPageLoad('$studyName','$siteNumber','$pageName','".BASE_URL.(is_numeric($studyName) && is_numeric($siteNumber) && is_numeric($pageName) ? $studyName."/".$siteNumber."/".$pageName : "")."');
                }
        
                getLinks(){
                  return $('a.nav-link')
                }
        
                loadPage(link){
                  const name = link.text()
                  const content = $('.page[data-page-name=\"' + name + '\"]')
                  
                  if(content.length === 0){
                    return
                  }
        
                  console.log('Loading Page:', name)
        
                  link.addClass('active')
                  $('.page').hide()
                  content.show()
        
                  this.getLinks().each((index, link) => {
                    $(link).removeClass('active')
                  })
                }
              }
              
              function waitForElementToExist(selector) {
                  return new Promise(resolve => {
                    if (document.querySelector(selector)) {
                      return resolve(document.querySelector(selector));
                    }
                
                    const observer = new MutationObserver(() => {
                      if (document.querySelector(selector)) {
                        resolve(document.querySelector(selector));
                        observer.disconnect();
                      }
                    });
                
                    observer.observe(document, {
                      subtree: true,
                      childList: true,
                    });
                  });
                }
                
        async function doWork() {
          const element = await waitForElementToExist('#main_inform_div');
          generateStudyPage('main_inform_div');
        }
        doWork();
        </script>";
    } catch (Exception $e) {
        echo "Module doesn't exist you stupid";
    }

?>
    <body>
        <div id="main_inform_div">

        </div>
    </body>
</html>