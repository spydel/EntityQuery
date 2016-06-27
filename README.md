Entity Query
===========

Sample
------
* @mixin EntityQuery
 
<?php

public function behaviors()
{
	return [
		'entityQuery' => EntityQuery::className(),
	];
}

/**
 * @return ActiveQuery
 */
private static function _getAllQuery()
{
	return self::find()->from(['product' => Product::tableName()])
		->where(['product.active' => self::STATUS_ACTIVE]);
}

/**
 * @param $categoryId
 * @return Product
 */
public static function getByCategoryId($categoryId)
{
	$query = self::_getAllQuery()->andWhere(['product.category_id' => $categoryId]);
	return (new Product())->set($query);
}


/** @var $categoryObj Category * */
$categoryObj = Category::getByUrl($url);

/** @var $category Category * */
$category = $categoryObj->addQuery($categoryObj->getQuery()->with(['parentIds', 'products' => function($query) use ($pagination) {
	/** @var $query ActiveQuery * */
	return $query
		// сортировка по умолчанию
		->orderBy(['product_rel_category.price' => SORT_ASC])
		->offset($pagination->getOffset())->limit($pagination->getLimit())
		->with(['mainImage', 'images']);
}]))->one();