<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */

use Robo\Common\TaskIO;
use Robo\Output;

class RoboFile extends \Robo\Tasks
{
    /**
     * Displays the introduction, more information and welcome ascii art
     */
    function info()
    {
        //Cat run/saucey.txt
        $this->taskExec('cat ./bin/saucey.txt')
            ->run();
    }

    /**
     * Starts apps/get.saucey.io in foreground at http://127.0.0.1:9987, kill with 'Control + C'
     */
    public function serve()
    {
        //Serve .
        $this->taskServer(8000)
            ->host('127.0.0.1')
            ->dir(".")
            ->run();
    }

    /**
     * Initializes saucey project via Composer install/update, npm global installs, and copying over behat.yml from vendor/saucey/framework
     */
    public function init()
    {
        //Install the dependancies/requirements through composer
        $this->taskComposerInstall('/usr/local/bin/composer')
            ->run();

        //Update the dependancies/requirements through composer
        $this->taskComposerUpdate('/usr/local/bin/composer')
            ->run();

        //Curl pip in ~/
        $this->taskExec('curl -o ~/get-pip.py https://bootstrap.pypa.io/get-pip.py')
            ->run();

        //Install pip via ~/get-pip.py
        $this->taskExec('sudo python ~/get-pip.py')
            ->run();

        //Install mkdocs
        $this->taskExec('sudo pip install mkdocs')
            ->run();

        //Install Wienre globally via npm
        $this->taskExec('sudo npm -g install weinre')
            ->run();

        //Install PhantomJS globally via npm
        $this->taskExec('sudo npm -g install phantomjs')
            ->run();

        //.BASH_PROFILE adjustments
        //Add t as alias to .bash_profile
        $this->taskExec('printf "\nalias t=\'python ~/Sites/saucey/vendor/saucey/framework/var/tasks/t/t.py --task-dir ~/Sites/saucey/var/tasks --list tasks\' \n" >> ~/.bash_profile')
            ->run();

        //Source .bash_profile
        $this->taskExec('source ~/.bash_profile')
            ->run();

        //Copy over behat.yml.master.dist to root as behat.yml
        $this->taskExec('cp ./vendor/saucey/framework/ymls/behat.yml.master.dist ./behat.yml')
            ->run();

        //Copy over bin from vendor/saucey/framework
        $this->taskExec('cp -R ./vendor/saucey/framework/bin/* ./bin/')
            ->run();

        //Make directory for reports, screenshots and tasks
        $this->taskFileSystemStack()
            ->mkdir('reports')
            ->mkdir('screenshots')
            ->mkdir('var/tasks')
            ->run();

        //Pull develop and master
        $this->taskGitStack()
            ->pull('origin', 'master')
            ->pull('origin', 'develop')
            ->run();

        //Temporary -- Function to move context from src/Temporary_Context -- MinkContext.php
        $this->taskExec('cp -R ./vendor/saucey/framework/src/Behat/Context ./vendor/behat/mink-extension/src/Behat/MinkExtension')
            ->run();

        //Temporary -- Function to move context from src/Temporary_Context -- MinkContext.php
        $this->taskExec('cp -R ./vendor/saucey/framework/src/Behatch/* ./vendor/behatch/contexts/src/Context')
            ->run();

        //View saucey introduction
        $this->taskExec('cat ./bin/saucey.txt')
            ->run();
    }

    /**
     * Runs Composer update, refreshes bin/ and vendor/
     */
    public function update()
    {
        //Update the dependancies/requirements through composer
        $this->taskComposerUpdate('/usr/local/bin/composer')
            ->run();

    }

    /**
     * Starts Winery (Weinre) in foreground, at $host $port
     */
    public function winery()
    {
        $host = $this->ask('What host?');
        $port = $this->ask('What port?');
        //Starts winery (weinre) in foreground, at $host $port
        $this->taskExec("weinre --verbose true --debug true --boundHost {$host} --httpPort {$port}")
            ->run();
    }

    /**
     * Starts Selenium for mac in foreground, at default http://localhost:4444/wd/hub/static/resource/hub.html
     */
    public function seleniumStart()
    {
        //Starts Selenium
        $this->taskExec('sh ./bin/start_selenium.sh')
            ->arg('mac')
            ->run();
    }

    /**
     * Kills Selenium at default http://localhost:4444/wd/hub/static/resource/hub.html
     */
    public function seleniumStop()
    {
        //Kills Selenium
        $this->taskExec("open http://localhost:4444/selenium-server/driver/?cmd=shutDownSeleniumServer")
            ->background()
            ->run();
    }

    /**
     * Starts PhantomJS for mac in foreground, at default http://localhost:4444/wd/hub/static/resource/hub.html
     *
     * * @param int $port Port for PhantomJS
     */
    public function phantomjs($port)
    {
        //Starts PhantomJS for mac
        $this->taskExec("/usr/local/bin/phantomjs --webdriver={$port}")
            ->run();
    }


    /**
     * Asks for and obtains $folder, $project, $feature, and $shortName. Makes directories, copies and touches files.
     *
     * @internal param string $folder
     * @internal param string $project
     * @internal param string $feature
     */
    public function sauceyBundle()
    {
        /**
         * @var string $folder
         */
        $folder = $this->ask("Which folder will this test(s) reside in? [string]");
        /**
         * @var string $project
         */
        $project = $this->ask("What is the name of the project? [string]");
        /**
         * @var string $feature
         */
        $feature = $this->ask("What is the name of the feature file? [string]");

        //Makes directories in feature/ and  feature file
        $this->taskFileSystemStack()
            ->mkdir("./features/{$folder}")
            ->mkdir("./features/{$folder}/{$project}")
            ->mkdir("./reports/{$folder}/{$project}")
            ->touch("./features/{$folder}/{$project}/{$feature}.feature")
            ->run();

    }

    /**
     * Asks for and obtains $project, $feature, and $number to update the Run.sh in feature directory. INIT, initializes script. RUN, runs script.
     *
     * @internal param string $folder
     * @internal param string $project
     * @internal param string $feature
     * @internal param string $number
     */
    public function sauceyOverdose()
    {
        $action = $this->ask("Would you like to init or run overdose? You have to init before running! [init | run]");
        $folder = $this->ask("Which folder does the test live in? [string]");
        $project = $this->ask("Which project? [string]");
        $number = $this->ask("How many times do you want to run this test? [int]");

        if ($action == 'init') {
            //Replaces number value in Run.sh
            $this->taskReplaceInFile("./features/{$folder}/{$project}/Run.sh")
                ->from('((n=0;n<1;n++))')
                ->to("((n=0;n<{$number};n++))")
                ->run();
        }
        if ($action == 'run') {
            $confirm = $this->ask("Are you sure you want to run your suite {$number} times? [y | n]");
            if ($confirm == 'y') {
                //Confirm then run
                $this->taskExec("sh ./features/{$folder}/{$project}/Run.sh")
                    ->run();
            }
            if ($confirm == 'n') {
                //Confirm
                $this->taskExec("exit")
                    ->run();
            }

        }
    }

    /**
     * Asks and obtains $project, $feature, $browser and $isMetrics status to run Behat, Reporting, Weinre, Selenium and PhantomJS
     *
     * @internal param string $folder
     * @internal param string $project
     * @internal param string $feature
     * @internal param string $isMetrics
     */
    public function testTipsy()
    {
        $project = $this->ask("What is the name of the parent folder in which this test resides? [string]");
        $feature = $this->ask("What is the '@tag' for feature? [string -- without '@']");
        $browser = $this->ask("Which browser is this to be test this in? [string]");
        $isMetrics = $this->ask("Is metrics testing involved? [y | n]");

        //Starts PhantomJS
        $this->taskExec("/usr/local/bin/phantomjs --webdriver=8643")
            ->background()
            ->run();

        //Starts Selenium
        $this->taskExec("sh ./run/start_selenium.sh mac")
            ->background()
            ->run();

        //Starts drivers, tests in parallel
        if ($isMetrics == 'y') {
            $metrics = $this->ask("What is the '@tag' for metrics? [string]");
            $host = $this->ask("What host? [string]");
            $port = $this->ask("What port? [string]");

            //Starts Winery
            $this->taskExec("weinre --verbose true --debug true --boundHost {$host} --httpPort {$port}")
                ->background()
                ->run();

            //Starts tests in parallel
            $this->taskParallelExec()
                ->process("sh ./run/saucey.sh tipsy '{$metrics} chrome'")
                ->process("sh ./run/saucey.sh tipsy '{$feature} {$browser}'")
                ->idleTimeout(10)
                ->run();

            $this->taskExec("open http://localhost:4444/selenium-server/driver/?cmd=shutDownSeleniumServer")
                ->background()
                ->run();

            $this->taskExec("mv ./reports/saucey_report.html ./reports/{$project}/{$feature}.html")
                ->background()
                ->idleTimeout(10)
                ->run();

            $this->taskExec("php ./feature/{$project}/{$feature}/Reporting.php")
                ->background()
                ->idleTimeout(10)
                ->run();
        }

        if ($isMetrics == 'n') {
            $this->taskParallelExec()
                //->process('sh ./run/start_selenium.sh mac')
                ->process("sh ./run/saucey.sh tipsy '{$feature} {$browser}'")
                ->idleTimeout(10)
                ->run();

            $this->taskExec("open http://localhost:4444/selenium-server/driver/?cmd=shutDownSeleniumServer")
                ->background()
                ->run();

            $this->taskExec("mv ./reports/saucey_report.html ./reports/{$project}/{$feature}.html")
                ->background()
                ->idleTimeout(10)
                ->run();

            $this->taskExec("php ./feature/{$project}/{$feature}/Reporting.php")
                ->background()
                ->idleTimeout(10)
                ->run();
        }
    }

    /**
     * Asks and obtains $project, $feature, $env and $browser to run Behat, Reporting and SauceLabs
     *
     * @internal param string $folder
     * @internal param string $project
     * @internal param string $env
     * @internal param string $browser
     */
    public function testDrunk()
    {
        $project = $this->ask("What is the name of the parent folder in which this test resides? [string]");
        $feature = $this->ask("What is the '@tag' for feature? [string -- without '@']");
        $env = $this->ask("What environment is this to be test this on? [string]");
        $browser = $this->ask("Which browser is this to be test this in? [string]");

        //Starts tests in parallel
        $this->taskParallelExec()
            ->process("sh ./run/saucey.sh drunk '{$feature} {$env} {$browser}'")
            ->idleTimeout(10)
            ->run();

        $this->taskExec("mv ./reports/saucey_report.html ./reports/{$project}/{$feature}.html")
            ->background()
            ->idleTimeout(10)
            ->run();

        $this->taskExec("php ./feature/{$project}/{$feature}/Reporting.php")
            ->background()
            ->idleTimeout(10)
            ->run();
    }

    /**
     * Hosts and opens local instance documentation
     */
    public function sauceyDocs()
    {
        //pull all documentation files
        $this->taskExec('cd ./docs/ && git clone https://github.com/getsaucey/saucey-docs.git')
            ->run();

        //change directory and serve
        $this->taskExec('cd ./docs/saucey-docs/ && mkdocs serve')
            ->run();
    }

    /**
     * Connects instance of sauce_connect to SauceLabs API, requires api_key and username
     *
     * @internal param string $un
     * @internal param string $key
     */
    public function sauceyConnect()
    {
        $un = $this->ask("What is your username?");
        $key = $this->ask("What is your api-key?");
        $unkey = "{$un}:{$key}";
        $un_key = "{$un} {$key}";

        $this->taskReplaceInFile('./vendor/saucey/framework/ymls/behat.yml.master.dist')
            ->from('username:api-key')
            ->to($unkey)
            ->run();

        $this->taskReplaceInFile('./behat.yml')
            ->from('username:api-key')
            ->to($unkey)
            ->run();

        $this->taskExec('./bin/sauce_config')
            ->arg($un_key)
            ->run();
    }

    /**
     * Starts a Sauce Tunnel, allowing testing on the local host against hosted selenium, with all SauceLabs functions
     *
     * @internal param string $un
     * @internal param string $key
     */
    public function sauceyTunnel()
    {
        $un = $this->ask("What is your username?");
        $key = $this->ask("What is your api-key?");
        $un_key = "{$un} {$key}";

        $this->taskExec('./vendor/sauce/connect/bin/sauce_connect')
            ->arg($un_key)
            ->run();
    }

    /**
     * For saucey developers, push and pull from framework GitHub with this task command
     *
     * @internal param string $un
     * @internal param string $key
     */
    public function sauceyShove($msg)
    {
        //Copy over development yaml
        $this->taskExec('cp -r ./behat.yml vendor/saucey/framework/ymls/behat.yml.master.dist')
            ->run();

        //Pull from remotes for saucey
        $this->taskGitStack()
            ->dir('.')
            ->pull('origin', 'master')
            ->pull('origin', 'develop')
            ->run();

        //Push to remotes for saucey
        $this->taskGitStack()
            ->dir('.')
            ->add('-A')
            ->commit($msg)
            ->push('origin', 'develop')
            ->run();
    }

    /**
     * Tests against saucey
     */
    public function sauceyTest()
    {
        // Tests Metrics by testing the app locally and verifying metrics locally
        $this->taskParallelExec()
            ->process('./bin/behat --tags "@saucey"')
            ->process('./bin/behat --tags "@sauceyMetrics" -p local_chrome')
            ->printed(true)
            ->run();

        // Tests against ie8 for Backup image
        $this->taskExec('./bin/behat --tags "@IE_Backup_TOR_Fragrance_APR15" -p sauce_windows_ie8')
            ->printed(true)
            ->run();

        // Tests against Windows Chrome
        $this->taskExec('./bin/behat --tags "@Compatibility_TOR_Fragrance_APR15" -p sauce_windows_chrome')
            ->printed(true)
            ->run();

        // Tests against i
        $this->taskExec('./bin/behat --tags "@IE_Backup_TOR_Fragrance_APR15" -p sauce_windows_ie8')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@Compatibility_TOR_Fragrance_APR15" -p sauce_windows_chrome')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@Compatibility_TOR_Fragrance_APR15" -p sauce_windows_firefox')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@Compatibility_TOR_Fragrance_APR15" -p sauce_mac_safari')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@Compatibility_TOR_Fragrance_APR15" -p sauce_mac_chrome')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@TOR_Fragrance_1032x1100_Tablet" -p sauce_ios_tablet_landscape')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@TOR_Fragrance_1032x1100_Tablet" -p sauce_android_tablet_landscape')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@TOR_Fragrance_1032x1100_Tablet" -p sauce_ios_tablet')
            ->printed(true)
            ->run();

        $this->taskExec('./bin/behat --tags "@TOR_Fragrance_1032x1100_Tablet" -p sauce_android_tablet')
            ->printed(true)
            ->run();
    }

}