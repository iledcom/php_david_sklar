<?php

function restaurant_check($meal, $tax, $tip) {
	$tax_amount = $meal * ($tax / 100);
	$tip_amount = $meal * ($tip / 100);
	$total_amount = $meal + $tax_amount + $tip_amount;
	return $total_amount;
}

function payment_method($cash_on_hand, $amount) {
	if ($amount > $cash_on_hand) {
		return 'credit card';
	} else {
		return 'cash';
	}
}

/*
class Entree {
	public $name;
	public $ingredients = array();
	public function hasIngredient($ingredient) {
		return in_array($ingredient, $this->ingredients);
	}
}
*/

/*
class Entree {
	public $name;
	public $ingredients = array();

	public function hasIngredient($ingredient) {
		return in_array($ingredient, $this->ingredients);
	}
	public static function getSizes() {
		return array('small','medium','large');
	}
}
*/
class Entree {
	public $name;
	public $ingredients = array();

	public function __construct($name, $ingredients) {
		if (! is_array($ingredients)) {
			throw new Exception('$ingredients must be an array');
		}
		$this->name = $name;
		$this->ingredients = $ingredients;
	}

	public function hasIngredient($ingredient) {
		return in_array($ingredient, $this->ingredients);
	}
}

class ComboMeal extends Entree {

	public function __construct($name, $entrees) {
		parent::__construct($name, $entrees);
		foreach ($entrees as $entree) {
			if (! $entree instanceof Entree) {
			throw new Exception(
			'Elements of $entrees must be Entree objects');
			}
		}
	}

	public function hasIngredient($ingredient) {
		foreach ($this->ingredients as $entree) {
			if ($entree->hasIngredient($ingredient)) {
				return true;
			}
		}
		return false;
	}
}


class Ingredient {
	protected $name;
	protected $cost;

	public function __construct($name, $cost) {
		$this->name = $name;
		$this->cost = $cost;
	}

	public function getName() {
		return $this->name;
	}

	public function getCost() {
		return $this->cost;
	}
	// В следующем методе задается новая величина
	// стоимости ингредиента блюда
	public function setCost($cost) {
		$this->cost = $cost;
	}
}

class PricedEntree extends Entree {
	public function ___construct($name, $ingredients) {
		parent::__construct($name, $ingredients);
		foreach ($this->ingredients as $ingredient) {
			if (! $ingredient instanceof Ingredient) {
				throw new Exception('Elements of $ingredients
				must be Ingredient objects');
			}
		}
	}

	public function getCost() {
		$cost = 0;
		foreach ($this->ingredients as $ingredient) {
			$cost += $ingredient->getCost();
		}
		return $cost;
	}
}




?>