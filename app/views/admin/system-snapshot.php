<?php
use TriTan\Container;
use TriTan\Common\Hooks\ActionFilterHook as hook;
/**
 * System Snapshot Report View
 *
 * @license GPLv3
 *
 * @since       0.9
 * @package     TriTan CMS
 * @author      Joshua Parker <joshmac3@icloud.com>
 */
$this->layout('main::_layouts/admin-layout');
$this->section('backend');
Container::getInstance()->{'set'}('screen_parent', 'dashboard');
Container::getInstance()->{'set'}('screen_child', 'snapshot');
$option = (
    new \TriTan\Common\Options\Options(
        new TriTan\Common\Options\OptionsMapper(
            new \TriTan\Database(),
            new TriTan\Common\Context\HelperContext()
        )
    )
);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-file-image-o"></i>
            <h3 class="box-title"><?= esc_html__('System Snapshot Report'); ?></h3>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">

        <?= (new \TriTan\Common\FlashMessages())->showMessage(); ?>

        <div class="box box-default">
            <pre>
                <?php
                $report = '';
                // add filter for adding to report opening
                $report .= hook::getInstance()->{'applyFilter'}('system_snapshot_report_before', '');

                $report .= "\n\t" . '** TriTan CMS DATA **' . PHP_EOL . PHP_EOL;
                $report .= 'Site URL:' . "\t\t\t\t\t\t" . site_url() . PHP_EOL;
                $report .= 'TriTan CMS Release:' . "\t\t\t\t\t" . CURRENT_RELEASE . PHP_EOL;
                $report .= 'API Key:' . "\t\t\t\t\t\t" . (preg_match('/\s/', $option->{'read'}('api_key')) ? '<font color="red">' . esc_html__('No') . '</font>' : '<font color="green">' . esc_html__('Yes') . '</font>') . PHP_EOL;
                $report .= "Active User Count:" . "\t\t\t\t\t" . (int) $this->user . PHP_EOL;
                $report .= sprintf("DB Errors:" . "\t\t\t\t\t\t" . ((int) $this->error <= 0 ? '<font color="green">0</font>' : '<font color="red">' . (int) $this->error . '</font> (<a href="%s"><strong>Click Here</strong></a>)'), admin_url('error/')) . PHP_EOL;
                $report .= "\n\t" . '** TriTan CMS CONFIG **' . PHP_EOL . PHP_EOL;
                $report .= 'Environment:' . "\t\t\t\t\t\t" . (APP_ENV == 'PROD' ? '<font color="green">' . esc_html__('Production') . '</font>' : '<font color="red">' . esc_html__('Development') . '</font>') . PHP_EOL;
                $report .= 'Base Path:' . "\t\t\t\t\t\t" . BASE_PATH . PHP_EOL;
                $report .= 'Application Path:' . "\t\t\t\t\t" . APP_PATH . PHP_EOL;

                $report .= "\n\t" . '** SERVER DATA **' . PHP_EOL . PHP_EOL;
                $report .= 'PHP Version:' . "\t\t\t\t\t\t" . PHP_VERSION . PHP_EOL;
                $report .= 'PHP Handler:' . "\t\t\t\t\t\t" . PHP_SAPI . PHP_EOL;
                $report .= 'Database Version:' . "\t\t\t\t\t" . '0.2.2' . PHP_EOL;
                $report .= 'Server Software:' . "\t\t\t\t\t" . $this->app->req->server['SERVER_SOFTWARE'] . PHP_EOL;

                $report .= "\n\t" . '** PHP CONFIGURATION **' . PHP_EOL . PHP_EOL;
                $report .= 'Memory Limit:' . "\t\t\t\t\t\t" . ini_get('memory_limit') . PHP_EOL;
                $report .= 'Upload Max:' . "\t\t\t\t\t\t" . ini_get('upload_max_filesize') . PHP_EOL;
                $report .= 'Post Max:' . "\t\t\t\t\t\t" . ini_get('post_max_size') . PHP_EOL;
                $report .= 'Time Limit:' . "\t\t\t\t\t\t" . ini_get('max_execution_time') . PHP_EOL;
                $report .= 'Max Input Vars:' . "\t\t\t\t\t\t" . ini_get('max_input_vars') . PHP_EOL;
                $report .= 'Cookie Path:' . "\t\t\t\t\t\t" . ((new \TriTan\Common\FileSystem(hook::getInstance()))->{'isWritable'}($this->app->config('cookies.savepath')) ? '<font color="green">' . $this->app->config('cookies.savepath') . '</font>' : '<font color="red">' . $this->app->config('cookies.savepath') . '</font>') . PHP_EOL;
                $report .= 'Regular Cookie TTL:' . "\t\t\t\t\t" . ttcms_seconds_to_time($this->app->config('cookies.lifetime')) . PHP_EOL;
                $report .= 'Secure Cookie TTL:' . "\t\t\t\t\t" . ttcms_seconds_to_time($option->{'read'}('cookieexpire')) . PHP_EOL;
                $report .= 'File Save Path:' . "\t\t\t\t\t\t" . ((new \TriTan\Common\FileSystem(hook::getInstance()))->{'isWritable'}(Container::getInstance()->{'get'}('site_path') . 'files' . DS) ? '<font color="green">' . Container::getInstance()->{'get'}('site_path') . 'files' . DS . '</font>' : '<font color="red">' . Container::getInstance()->{'get'}('site_path') . 'files' . DS . '</font>') . PHP_EOL;
                $report .= 'TriTan CMS Node:' . "\t\t\t\t\t" . ((new \TriTan\Common\FileSystem(hook::getInstance()))->{'isWritable'}(TTCMS_NODEQ_PATH) ? '<font color="green">' . TTCMS_NODEQ_PATH . '</font>' : '<font color="red">' . TTCMS_NODEQ_PATH . '</font>') . PHP_EOL;
                $report .= 'cURL Enabled:' . "\t\t\t\t\t\t" . (function_exists('curl_version') ? '<font color="green">' . esc_html__('Yes') . '</font>' : '<font color="red">' . esc_html__('No') . '</font>') . PHP_EOL;

                // add filter for end of report
                $report .= hook::getInstance()->{'applyFilter'}('system_snapshot_report_after', '');
                // end it all
                $report .= PHP_EOL;

                echo $report;

                ?>
            </pre>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
$this->stop();
