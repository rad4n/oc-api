<?php
class ControllerApiProduct extends Controller {
  public function index() {
		$this->load->language('api/currency');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
      $this->load->model('catalog/product');

			$products = $this->model_catalog_product->getProducts();
      if ($products) {
        foreach($products as $product){
          //$json['product'] = json_encode($product);
          $json['products'][] = array(
  					'product_id' => $product['product_id'],
  					'name'       => $product['name'],
  					'model'      => $product['model'],
  					'quantity'   => $product['quantity'],
  					'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
  					'reward'     => $product['reward']
  				);
        }
      } else {
        $json['error'] = "No avaible products";
      }
    }
    $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
  }
}
?>