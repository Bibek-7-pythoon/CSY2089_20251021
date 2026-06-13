<?php
require_once __DIR__ . '/../JoJobs/Entities/AbstractEntity.php';
require_once __DIR__ . '/../JoJobs/Entities/Job.php';

use PHPUnit\Framework\TestCase;
use JoJobs\Entities\Job;

class EntityTest extends TestCase
{
    public function testEntitySupportsArrayAccessAndProperties(): void
    {
        $job = new Job(['id' => 1, 'title' => 'Developer']);

        $this->assertSame('Developer', $job['title']);
        $this->assertSame('Developer', $job->title);

        $job['location'] = 'Northampton';
        $this->assertSame('Northampton', $job->location);
    }
}
