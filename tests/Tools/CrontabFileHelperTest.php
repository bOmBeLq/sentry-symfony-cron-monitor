<?php

namespace Tools;

use bmL\SentryCronMonitorBundle\Tools\CrontabFileHelper;
use PHPUnit\Framework\TestCase;

class CrontabFileHelperTest extends TestCase
{
    /**
     * @dataProvider addScheduleArgumentToCrontabFileContentsDataProvider
     */
    public function testAddScheduleArgumentToCrontabFileContents(string $file, string $expectedFile): void
    {
        $file = __DIR__ . '/_resources/' . $file;
        $expectedFile = __DIR__ . '/_resources/' . $expectedFile;

        $tmpFile = sys_get_temp_dir() . '/' . uniqid();
        copy($file, $tmpFile);
        $helper = new CrontabFileHelper();
        $helper->addScheduleArgumentToCrontabFileContents($tmpFile);
        $this->assertEquals(file_get_contents($expectedFile), file_get_contents($tmpFile));
        unlink($tmpFile);
    }

    public function addScheduleArgumentToCrontabFileContentsDataProvider(): array
    {
        return [
            ['crontab', 'crontab.expected'],
            ['crontab_no_user', 'crontab_no_user.expected'],
        ];
    }
}
