<?php
use PHPUnit\Framework\TestCase;

class QPXRequestTest extends TestCase {

	public function testPass() {
		// Assert
		$this->assertEquals(-1, 1-2);
	}

	public function testFail() {
        // Assert
        $this->assertEquals(-1, 1);
    }

}


?>
