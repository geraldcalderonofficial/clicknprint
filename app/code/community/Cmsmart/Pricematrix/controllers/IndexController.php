<?php
/**
 * @author Pham Hong Thanh
 * @email thanhpham0990@gmail.com
 * @skype thanhpham170990
 */

class Cmsmart_Pricematrix_IndexController extends Mage_Core_Controller_Front_Action{

    /**
     * Save data to vertical and horizontal table
     * Show data to vertical and horizontal group
     */
    public function indexAction(){

        /**
         * Get param sent from phtml
         */
        $params = $this->getRequest()->getParams();

        $product = $params['matrix_product'];

        $direct = $params['direct'];

        if(array_key_exists('attr', $params)){
            $params = $params['attr'];
        }else{
            return;
        }

        /**
         * Truncate vertical horizontal table
         */
        $model = Mage::getModel('cmsmart_pricematrix/'.$direct);

        $collection = $model->getCollection()->addFieldToFilter('product', array('eq'=>$product));

        foreach($collection as $option){
            $option->delete();
        }

        /**
         * Add new attribute to vertical or horizontal table
         */
        for($i=0; $i<count($params); $i++){
            $optionId = $params[$i];
            $optionModel = Mage::getModel('catalog/product_option');
            $option = $optionModel->load($optionId);
            $title = $optionModel->getOptionTitle($option);
            try{
                $data = array(
                    'product' => $product,
                    'title' => $title,
                    'value' => $optionId
                );
                $model->setData($data)->save();
            }catch (Exception $e){
                Mage::throwException('Error when save option has id: '. $optionId);
            }
        }


        /**
         * Prepare input array
         *
         */

        $input = array();
        for($i=0; $i<count($params); $i++){
            $optionId = $params[$i];

            $y = array();

            $optionModel = Mage::getModel('catalog/product_option');
            $option = $optionModel->load($optionId);

            $title = $optionModel->getOptionTitle($option); // Ex: Color

            $optionValueModel = Mage::getModel('catalog/product_option_value');
            $collection = $optionValueModel->getValuesCollection($option);

            $k = 0;
            foreach($collection as $optionValue){
                $optionValueId = $optionValue->getId();

                $x = array();

                $optionTypeTitleModel = Mage::getModel('cmsmart_pricematrix/catalog_product_option_type_title');
                $collection = $optionTypeTitleModel->getCollection()->addFieldToFilter('option_type_id', $optionValueId);

                foreach($collection as $item){
                    $typeTitle[$k] = $item->getTitle();
                }

                $optionTypePriceModel = Mage::getModel('cmsmart_pricematrix/catalog_product_option_type_price');
                $collection = $optionTypePriceModel->getCollection()->addFieldToFilter('option_type_id', $optionValueId);
                foreach($collection as $item){
                    $typePrice = $item->getPrice();
                    $typePriceType = $item->getPriceType();
                }

                /**
                 * Get base price of current product
                 */
                $_product = Mage::getModel('catalog/product')->load($product);
                $basePrice = (float)$_product->getFinalPrice();

                /**
                 * Assign value to input array
                 */

                $quantityTitle = Mage::helper('cmsmart_pricematrix')->getQuantityTitle();

                if($title === $quantityTitle){
                    if($k<1){
                        $min = 1; $max = $typeTitle[$k];
                    }else{
                        $min = $typeTitle[$k-1] + 1; $max = $typeTitle[$k];
                    }
                    $x['qty'] = (string)$min.'-'.(string)$max;
                    $x['minqty'] = $min;
                }else{
                    $x['qty'] = '';
                    $x['minqty'] = '';
                }

                $x['full_title'] = $x['title'] = (string)$typeTitle[$k];
                $x['value'] = array($optionId => $optionValueId);
                if($typePriceType === 'percent'){
                    $typePrice = ($basePrice * $typePrice)/100;
                }

                $x['price'] = $typePrice;
                if($title === $quantityTitle){
                    $x['tooltip'] = array((string)$x['qty'] => (string)$typePrice);
                }else{
                    $x['tooltip'] = array((string)$typeTitle[$k] => (string)$typePrice);
                }

                $y[] = $x;

                $k++;
            }
            $input[] = $y;
        }

//        $input = array(
//         $y = array(
//           $x = array(
//                    'option' => 'Quantity'
//                    'qty' => '1-100'
//                    'title' => '100',
//                    'value' => array(17=>3),
//                    'price' => '4$',
//                    'tooltip' => array(100 => 4$)
//                ),
//            $x = array(
//                    'option' => 'Quantity'
//                    'qty' => '101-200'
//                    'title' => '200',
//                    'value' => array(17=>4),
//                    'price' => '5$'
//                    'tooltip' => array(200 => 5$)
//                )
//            ),
//            array(
//                array(
//                    'option' => 'Color'
//                    'qty' => ''
//                    'title' => 'Red',
//                    'value' => array(20=>6)
//                    'price' => '6$',
//                    'tooltip' => array(Red => 6$)
//                ),
//                array(
//                    'option' => 'Color'
//                    'qty' => ''
//                    'title' => 'Blue',
//                    'value' => array(20=>8)
//                    'price' => '4$',
//                    'tooltip' => array(Blue => 7$)
//                )
//            )
//        );


        /**
         * Prepare data to show checkbox on groups
         */
        $output = $this->combinations($input, $i=0);

        echo json_encode($output);
    }

    /**
     * Combination options
     * @param $arrays
     * @param int $i
     * @return array
     */
    public function combinations($arrays, $i = 0) {

        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = $this->combinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $temp = array();
                $temp['first_title'] = $v['title'];
                $temp['first_count'] = count($arrays[0]);
                if($i == 0){
                    $temp['title'] = $t['title'];
                }else{
                    $temp['title'] = $v['title']. Mage::helper('cmsmart_pricematrix')->getDelimiter() .$t['title'];
                }

                $temp['qty'] = $v['qty'].$t['qty'];
                $temp['minqty'] = $v['minqty'].$t['minqty'];
                $temp['full_title'] = $v['full_title']. Mage::helper('cmsmart_pricematrix')->getDelimiter() .$t['full_title'];
                $temp['value'] = $v['value'] + $t['value'];
                $temp['price'] = (float)$v['price'] + (float)$t['price'];
                $temp['tooltip'] = $v['tooltip'] + $t['tooltip'];
                $result[] = $temp;
            }
        }

        return $result;
    }

    /**
     * Save data to verticalhorizontal table
     * Show data to price matrix
     */
    public function matrixAction(){

        $params = $this->getRequest()->getParams();
        $product = $params['matrix_product'];
        if(array_key_exists('attr', $params)){
            $vertical = $params['attr']['vertical'];
            $horizontal = $params['attr']['horizontal'];
        }else{
            return;
        }


        /**
         * Truncate vertical horizontal group table
         */
        $verticalhorizontalModel = Mage::getModel('cmsmart_pricematrix/verticalhorizontal');
        $collection = $verticalhorizontalModel->getCollection()->addFieldToFilter('product', array('eq'=>$product));
        foreach($collection as $optionGroup){
            $optionGroup->delete();
        }


        /**
         * Save new group of attributes to table (vertical_horizontal_group)
         */

        for($i=0; $i<count($vertical); $i++){
            $item = json_decode($vertical[$i],true);
            $data = array(
                'product' => $product,
                'title' => $item['full_title'],
                'value' => $vertical[$i],
                'direct' => 'vertical'
            );
            $verticalhorizontalModel->setData($data)->save();
        }

        for($i=0; $i<count($horizontal); $i++){
            $item = json_decode($horizontal[$i],true);
            $data = array(
                'product' => $product,
                'title' => $item['full_title'],
                'value' => $horizontal[$i],
                'direct' => 'horizontal'
            );
            $verticalhorizontalModel->setData($data)->save();
        }

        /**
         * Prepare data to save and show price matrix
         */
        if(array_key_exists('attr', $params)){

            $vertical = $params['attr']['vertical'];
            $horizontal = $params['attr']['horizontal'];

            $html = "<table id='pricematrix-table'><tr>";

            for($i=0; $i<= (count($vertical) + 1); $i++){
                if($i == 0){
                    // th empty first
                        $html.= "<th colspan='2' rowspan='2' style='color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'></th>";

//                    $html.= "<th style='color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'></th>";
                }elseif($i == 1){
//                    // th empty first
//                    $html.= "<th style='color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'></th>";
//                    $html.= "<th style='color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'></th>";
                }else{
                    $v = json_decode($vertical[$i-2],true);
                    if(isset($v['first_count'])){
                        $rowspan = count($vertical)/(float)$v['first_count'];
                        if(($i - 1)%$rowspan == 1){
                            $html.= "<td rowspan='".$rowspan."' style='font-size:1.1em; font-weight:bold; color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'>".$v['first_title']."</td>";
                        }
                        $html.= "<td style='font-size:1.1em; font-weight:bold; color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'>".$v['title']."</td>";
                    }else{
                        $html.= "<td colspan='2' style='font-size:1.1em; font-weight:bold; color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'>".$v['title']."</td>";
                    }
                }

                for($j=0; $j<count($horizontal); $j++){
                    $h = json_decode($horizontal[$j],true);
                    if($i==0){
                        $colspan = count($horizontal)/(float)$h['first_count'];
                        if($j%$colspan == 1){
                            $html.= "<td colspan='".$colspan."' style='font-size:1.1em; font-weight:bold; color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'>".$h['first_title']."</td>";
                        }
                    }elseif($i==1){
                        $html .= "<th style='color:".Mage::helper('cmsmart_pricematrix')->getTextColor()."; background-color:".Mage::helper('cmsmart_pricematrix')->getBackgroundColor()."'>".$h['title']."</th>";
                    }else{
                        $symbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
                        $basePrice = Mage::getModel('catalog/product')->load($product)->getFinalPrice();
                        $finalPrice = (float)$basePrice + (float)$v['price']  + (float)$h['price'];
                        $html .= "<td minqty='".$v['minqty'].$h['minqty']."' range='".$v['qty'].$h['qty']."' class='column-".$j."' tooltip='";
                        $html .= "<table>";
                        $tooltip = ($v['tooltip']+$h['tooltip']);
                        foreach($tooltip as $key=>$val){
                            $html .= "<tr><td>". $key . "</td><td> : " . (float)$val.$symbol."</td></tr>";
                        }
                        $html .= "<tr><td>Base price</td><td> : ".$basePrice.$symbol."</td></tr>";
                        $html .= "<tr><td colspan=\"2\"><hr /></td></tr>";
                        $html .= "<tr><td>Total price</td><td> : " . $finalPrice.$symbol. "</td></tr>";
                        $html .= "</table>";
                        $html .= "'>";
                        $html .= "<input style='display:none;' onchange='opConfig.reloadPrice()' class='product-pricematrix-option' type='radio' name='matrix_options' title='". json_encode($tooltip) ."' value='".json_encode(($v['value']+$h['value']))."' /><span class='price_td'>". $finalPrice . "</span>".$symbol."</td>";
                    }
                }

                if($i%2==0)
                    $html .= "</tr><tr>";
                else
                    $html .= "</tr><tr class='alt'>";
            }

            $html .="</tr></table>";

            /**
             * Delete and save matrix to database
             */
            $matrixModel = Mage::getModel('cmsmart_pricematrix/matrix');
            $collection = $matrixModel->getCollection()->addFieldToFilter('product', array('eq'=>$product));
            foreach($collection as $matrix){
                $matrix->delete();
            }
            $data = array(
                'product' => $product,
                'value' => json_encode($html)
            );
            $matrixModel->setData($data)->save();


            /**
             * Prepare matrix to preview
             */
            echo json_encode($html);
        }
    }


//    public function combinationsGoc($arrays, $i = 0) {
//
//        if (!isset($arrays[$i])) {
//            return array();
//        }
//        if ($i == count($arrays) - 1) {
//            return $arrays[$i];
//        }
//
//        // get combinations from subsequent arrays
//        $tmp = $this->combinations($arrays, $i + 1);
//
//        $result = array();
//
//        // concat each array from tmp with each element from $arrays[$i]
//        foreach ($arrays[$i] as $v) {
//            foreach ($tmp as $t) {
//                $result[] = is_array($t) ?
//                    array_merge_recursive($v, $t) :
//                    array($v, $t);
//            }
//        }
//
//        return $result;
//    }

}