<?php
class Dinamic_Customcheckout_CustomcartController extends Mage_Core_Controller_Front_Action
{
    public function ajaxupdatecartAction(){
    	
    	$simbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();  // GET THE CURRENCY SIMBOL
		$store 	= Mage::app()->getStore()->getCode();  // GET THE STORE CODE
		 
		$cart 	= Mage::getSingleton('checkout/cart'); //->getItemsCount();   
		 
		$ajtem 	= $_POST['item'];    // THIS IS THE ITEM ID
		$items 	= $cart->getItems();
		foreach ($items as $item) {   // LOOP
		   if($item->getId()==$ajtem){  // IS THIS THE ITEM WE ARE CHANGING? IF IT IS:
		   	   $item->setQty($_POST['qty']); // UPDATE ONLY THE QTY, NOTHING ELSE!
		   	   $cart->save();  // SAVE
		   	   Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		       echo '<span>';   
		       if($store=='en')  echo $simbol;
		       echo number_format($item->getPriceInclTax() * $_POST['qty'],2);
		       if($store=='hr')  echo ' '.$simbol;
		       echo '</span>';
		   	   break;
		   }
		 
		}
		// THE REST IS updatTotalG FUNCTION WHICH IS CALLED AFTER AJAX IS COMPLETED 
		// (UPDATE THE TOTALS)
		echo '<script type="text/javascript">';
		echo 'function updateTotalG(){';
		//echo 'jQuery("#count_mini_cart").html(parseInt(jQuery("#count_mini_cart").html())+1);';
		echo 'jQuery("#shopping-cart-totals-table .price").html(\'';
		if($store!='hr')  
			echo $simbol;
		echo number_format(Mage::getSingleton('checkout/session')->getQuote()->getGrandTotal(),2);
		if($store=='hr')  
			echo ' '.$simbol;
		echo "')}   </script>";
    }
}
?>