# Search Plugin for CakePHP #

Version 1.1 for cake 1.3

The Search plugin allows you to make any kind of data searchable, enabling you to implement a robust searching rapidly.

The Search plugin is an easy way to include search into your application, and provides you with a paginate-able search in any controller.

It supports simple methods to search inside models using strict and non-strict comparing, but also allows you to implement any complex type of searching.

## Sample of usage ##

An example of how to implement complex searching in your application.

Model code:

	class Article extends AppModel {

		public $actsAs = array('Search.Searchable');
		public $belongsTo = array('User');
		public $hasAndBelongsToMany = array('Tag' => array('with' => 'Tagged'));

		public $filterArgs = array(
			array('name' => 'title', 'type' => 'like'),
			array('name' => 'status', 'type' => 'value'),
			array('name' => 'blog_id', 'type' => 'value'),
			array('name' => 'search', 'type' => 'like', 'field' => 'Article.description'),
			array('name' => 'range', 'type' => 'expression', 'method' => 'makeRangeCondition', 'field' => 'Article.views BETWEEN ? AND ?'),
			array('name' => 'username', 'type' => 'like', 'field' => 'User.username'),
			array('name' => 'tags', 'type' => 'subquery', 'method' => 'findByTags', 'field' => 'Article.id'),
			array('name' => 'filter', 'type' => 'query', 'method' => 'orConditions'),
		);

		public function findByTags($data = array()) {
			$this->Tagged->Behaviors->attach('Containable', array('autoFields' => false));
			$this->Tagged->Behaviors->attach('Search.Searchable');
			$query = $this->Tagged->getQuery('all', array(
				'conditions' => array('Tag.name'  => $data['tags']),
				'fields' => array('foreign_key'),
				'contain' => array('Tag')
			));
			return $query;
		}

		public function orConditions($data = array()) {
			$filter = $data['filter'];
			$cond = array(
				'OR' => array(
					$this->alias . '.title LIKE' => '%' . $filter . '%',
					$this->alias . '.body LIKE' => '%' . $filter . '%',
				));
			return $cond;
		}
	}

Associated snippet for the controller class:

	class ArticlesController extends AppController {
		public $components = array('Search.Prg');

		public $presetVars = array(
			array('field' => 'title', 'type' => 'value'),
			array('field' => 'status', 'type' => 'checkbox'),
			array('field' => 'blog_id', 'type' => 'lookup', 'formField' => 'blog_input', 'modelField' => 'title', 'model' => 'Blog'));

		public function find() {
			$this->Prg->commonProcess();
			$this->paginate['conditions'] = $this->Article->parseCriteria($this->passedArgs);
			$this->set('articles', $this->paginate());
		}
	}

The `find.ctp` view is the same as `index.ctp` with the addition of the search form:

	echo $this->Form->create('Article', array(
		'url' => array_merge(array('action' => 'find'), $this->params['pass'])
	));
	echo $this->Form->input('title', array('div' => false));
	echo $this->Form->input('blog_id', array('div' => false, 'options' => $blogs));
	echo $this->Form->input('status', array('div' => false, 'multiple' => 'checkbox', 'options' => array('open', 'closed')));
	echo $this->Form->input('username', array('div' => false));
	echo $this->Form->submit(__('Search', true), array('div' => false));
	echo $this->Form->end();

In this example on model level shon example of search by OR condition. For this purpose defined method orConditions and added filter arg `array('name' => 'filter', 'type' => 'query', 'method' => 'orConditions')`.

## Behavior and Model configuration ##

All search fields need to be configured in the Model::filterArgs array. 

Each filter record should contain array with several keys:

* name - the parameter stored in Model::data. In the example above the 'search' name used to search in the Article.description field.
* type - one of supported search types described below.
* field - Real field name used for search should be used.
* method - model method name or behavior used to generate expression, subquery or query.
* allowEmpty - optional parameter used for expression, subquery and query methods. It allow to generate condition even if filter field value is empty. It could used when condition generate based on several other fields. All fields data passed to method.

### Supported types of search ###

* 'like' or 'string'. This type of search used when you need to search using 'LIKE' sql keyword.
* 'value' or 'int'. This type of search very useful when you need exact compare. So if you have select box in your view as a filter than you definitely should  use value type.
* 'expression' type useful if you want to add condition that will generate by some method, and condition field contain several parameter like in previous sample used for 'range'. Field here contains 'Article.views BETWEEN ? AND ?' and Article::makeRangeCondition returns array of two values.
* 'subquery' type useful if you want to add condition that looks like FIELD IN (SUBQUERY), where SUBQUERY generated by method declared in this filter configuration.
* 'query' most universal type of search. In this case method should return array(that contain condition of any complexity). Returned condition will joined to whole search conditions.
  
## Post, redirect, get concept ##

Post/Redirect/Get (PRG) is a common design pattern for web developers to help avoid certain duplicate form submissions and allow user agents to behave more intuitively with bookmarks and the refresh button.

When a web form is submitted to a server through an HTTP POST request, a web user that attempts to refresh the server response in certain user agents can cause the contents of the original HTTP POST request to be resubmitted, possibly causing undesired results. To avoid this problem possible to use the PRG pattern instead of returning a web page directly, the POST operation returns a redirection command, instructing the browser to load a different page (or same page) using an HTTP GET request. See the [Wikipedia article](http://en.wikipedia.org/wiki/Post/Redirect/Get) for more information.
	
## PRG Component features ##

The Prg component implements the PRG pattern so you can use it separately from search tasks when you need it.

The component maintains passed and named parameters that come as POST parameters and transform it to the named during redirect, and sets Controller::data back if the GET method was used during component call.

Most importantly the component acts as the glue between your app and the searchable behavior.

### Controller configuration ###

All search fields parameters need to configure in the Controller::presetVars array. 

Each preset variable is a array record that contains next keys:
  
* field      - field that defined in the view search form.
* type       - one of search types: 
 * value - should used for value that does not require any processing, 
 * checkbox - used for checkbox fields in view (Prg component pack and unpack checkbox values when pass it through the get named action).
 * lookup - this type used when you have autocomplete lookup field implemented in your view. This lookup field is a text field, and also you have hidden field id value. In this case component will fill both text and id values.  
* model      - param that specifies what model used in Controller::data at a key for this field.
* formField  - field in the form that contain text, and will populated using model.modelField based on field value.
* modelField - field in the model that contain text, and will used to fill formField in view.
* encode     - boolean, by default false. If you want to use search strings in URL's with special characters like % or / you need to use encoding
  
### Prg::commonProcess method usage ###

The `commonProcess` method defined in the Prg component allows you to inject search in any index controller with just 1-2 lines of additional code.

You should pass model name that used for search. By default it is default Controller::modelClass model.

Additional options parameters:

* form        - search form name.
* keepPassed  - parameter that describe if you need to merge passedArgs to Get url where you will Redirect after Post
* action      - sometimes you want to have different actions for post and get. In this case you can define get action using this parameter.
* modelMethod - method, used to filter named parameters, passed from form. By default it is validateSearch, and it defined in Searchable behavior.

## Requirements ##

* PHP version: PHP 5.2+
* CakePHP version: Cakephp 1.3 Stable

## Support ##

For support and feature request, please visit the [Search Plugin Support Site](http://cakedc.lighthouseapp.com/projects/59618-search-plugin/).

For more information about our Professional CakePHP Services please visit the [Cake Development Corporation website](http://cakedc.com).

## Branch strategy ##

The master branch holds the STABLE latest version of the plugin. 
Develop branch is UNSTABLE and used to test new features before releasing them. 

Previous maintenance versions are named after the CakePHP compatible version, for example, branch 1.3 is the maintenance version compatible with CakePHP 1.3.
All versions are updated with security patches.

## Contributing to this Plugin ##

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features. If you want to contribute some code, create a feature branch from develop, and send us your pull request. Unit tests for new features and issues detected are mandatory to keep quality high. 


## License ##

Copyright 2009-2010, [Cake Development Corporation](http://cakedc.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2009-2011<br/>
[Cake Development Corporation](http://cakedc.com)<br/>
1785 E. Sahara Avenue, Suite 490-423<br/>
Las Vegas, Nevada 89104<br/>
http://cakedc.com<br/>
