<?php

namespace TierPricingTable\Admin\Import;

use  WC_Product ;
class Woocommerce
{
    /**
     * Import constructor.
     */
    public function __construct()
    {
        add_filter( 'woocommerce_csv_product_import_mapping_options', [ $this, 'addColumnsToImporter' ] );
        add_filter( 'woocommerce_csv_product_import_mapping_default_columns', [ $this, 'addColumnToMappingScreen' ] );
        add_filter(
            'woocommerce_product_import_pre_insert_product_object',
            [ $this, 'processImport' ],
            10,
            2
        );
    }
    
    /**
     * Register the 'Tiered pricing' column in the importer.
     *
     * @param array $options
     *
     * @return array $options
     */
    public function addColumnsToImporter( $options )
    {
        $options['tiered_price_fixed'] = __( 'Fixed Tiered prices', 'tier-pricing-table' );
        return $options;
    }
    
    /**
     * Add automatic mapping support for 'Tiered pricing'.
     *
     * @param array $columns
     *
     * @return array $columns
     */
    public function addColumnToMappingScreen( $columns )
    {
        $columns[__( 'Fixed Tiered prices', 'tier-pricing-table' )] = 'tiered_price_fixed';
        return $columns;
    }
    
    /**
     * Process the data read from the CSV file.
     *
     * @param WC_Product $product - Product being imported or updated.
     * @param array $data - CSV data read for the product.
     *
     * @return WC_Product $object
     */
    public function processImport( $product, $data )
    {
        
        if ( !empty($data['tiered_price_fixed']) ) {
            $fixedData = $this->decodeExport( $data['tiered_price_fixed'] );
            if ( $fixedData && !empty($fixedData) ) {
                $product->update_meta_data( '_fixed_price_rules', $fixedData );
            }
        } else {
            $product->update_meta_data( '_fixed_price_rules', array() );
        }
        
        return $product;
    }
    
    /**
     * Decode export file format to array
     *
     * @param string $data
     *
     * @return array
     */
    protected function decodeExport( $data )
    {
        $rules = explode( ",", $data );
        $data = [];
        if ( $rules ) {
            foreach ( $rules as $rule ) {
                $rule = explode( ':', $rule );
                if ( isset( $rule[0] ) && isset( $rule[1] ) ) {
                    $data[intval( $rule[0] )] = $rule[1];
                }
            }
        }
        $data = array_filter( $data );
        return ( !empty($data) ? $data : [] );
    }

}