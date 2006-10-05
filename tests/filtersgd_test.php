<?php
/**
 * ezcImageConversionHandlerGdTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ImageFiltersGd class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionFiltersGdTest extends ezcImageConversionTestCase
{
    protected $handler;

    protected $imageReference;

    protected function getActiveResource()
    {
        /*
         * @todo Possible bug in Reflection API?
         *
        echo "\n--- Handler object ---\n";
        var_dump( $this->handler );
        $obj = new ReflectionObject( $this->handler );
        echo "\n--- Handler reflection object ---\n";
        var_dump( $obj );
        $atts = $obj->getProperties();
        echo "\n--- Handler reflection attribute objects ---\n";
        var_dump( $atts );
        echo "\n--- Handler reflection has property activeReference ---\n";
        var_dump( $obj->hasProperty( "activeReference" ) );
        echo "\n--- Now trying ->getProperty( activeReference ) ---\n";
        $att = $obj->getProperty( "activeReference" );
        echo "\n--- Handler reflection attribute object for activeReference ---\n";
        var_dump( $att );
        $activeReference = $this->getAttribute( $this->handler, "activeReference" );
        $references = $this->getAttribute( $this->handler, "references" );
        */
        $handlerArr = ( array) $this->handler;
        $reference = $handlerArr["\0ezcImageMethodcallHandler\0activeReference"];
        $referenceData = $handlerArr["\0ezcImageMethodcallHandler\0references"][$reference];
        return $referenceData["resource"];
    }

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionFiltersGdTest" );
	}

    protected function setUp()
    {
        try
        {
            $this->handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
        $this->imageReference = $this->handler->load( $this->testFiles["jpeg"] );
    }

    protected function tearDown()
    {
        unset( $this->handler );
    }

    public function testScaleBoth()
    {
        $this->handler->scale( 500, 500, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            500,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            377,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleDown_do()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 2, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            3,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            2,
            imagesy( $this->getActiveResource() ),
            "Height of scaled image incorrect."
        );
    }

    public function testScaleDown_dont()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 200, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Height of scaled image incorrect."
        );
    }

    public function testScaleUp_do()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 300, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            398,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            300,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleUp_dont()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 2, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            $oldDim["y"],
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthBoth()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            50,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            37,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthUp_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthUp_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            300,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            226,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthDown_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthDown_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            50,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            38,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightBoth()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            66,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            50,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightUp_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 226, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            300,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            226,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightUp_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightDown_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightDown_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            66,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            50,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScalePercent_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scalePercent( 50, 50 );
        $this->assertEquals(
            75,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            57,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScalePercent_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scalePercent( 200, 200 );
        $this->assertEquals(
            300,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            226,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleExact_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleExact( 200, 200 );
        $this->assertEquals(
            200,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            200,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleExact_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleExact( 10, 200 );
        $this->assertEquals(
            10,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            200,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleExact_3()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleExact( 200, 10 );
        $this->assertEquals(
            200,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            10,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testCrop_1()
    {
        $this->handler->crop( 50, 38, 50, 37 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCrop_2()
    {
        $this->handler->crop( 100, 75, -50, -37 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCrop_3()
    {
        $this->handler->crop( 50, 75, 250, 38 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCrop_0_Offset()
    {
        $this->handler->crop( 0, 0, 10, 10 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testColorspaceGrey()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_GREY );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testColorspaceMonochrome()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_MONOCHROME );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testColorspaceSepia()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_SEPIA );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }
}
?>
