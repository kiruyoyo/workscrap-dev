<?php


namespace App\Controllers\Admin;


use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\ValidateRequest;
use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\SubCategory;
use Exception;

class ServiceCategoryController extends BaseController
{
    public $table_name='categories';
    public $categories;
    public $subcategories;
    public $subcategories_links;
    public $links;
    public function __construct()
    {
        $total=Category::all()->count();
        $subTotal =SubCategory::all()->count();
        $object = new Category;
        list($this->categories,$this->links)=paginate(4,$total,$this->table_name,$object);
        list($this->subcategories,$this->subcategories_links)=paginate(4,$subTotal,'sub_categories',new SubCategory);
    }

    public function show()
    {

        return view('admin/service/categories',[
        'categories'=>$this->categories,'links'=>$this->links,
         'subcategories'=>$this->subcategories,'subcategories_links'=>$this->subcategories_links,
        ]);

    }


    public function store()
    {
        if(Request::has('post')){
            $request= Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token))
            {
                $rules =['name'=>['required'=>true,'maxLength'=>20,'string'=>true,'unique'=>'categories']];

                $validate=new ValidateRequest;
                $validate->abide($_POST,$rules);

                if ($validate->hasError()){
                    $errors = $validate->getErrorMessages();
                    return view('admin/service/categories',[
                        'categories'=>$this->categories,'links'=>$this->links,'errors'=>$errors,
                        'subcategories'=>$this->subcategories,'subcategories_links'=>$this->subcategories_links,
                    ]);
                }
                //process data
                 Category::create([
                    'name'=>$request->name,
                    'slug'=>slug($request->name)
                ]);
                $total=Category::all()->count();
                $SubTotal=SubCategory::all()->count();
                list($this->categories,$this->links)=paginate(4,$total,$this->table_name,new Category);
                list($this->subcategories,$this->subcategories_links)=paginate(4,$SubTotal,'sub_categories',new SubCategory);
                return view('admin/service/categories',[
                    'categories'=>$this->categories,'links'=>$this->links,'success'=>'Category Created Successfully',
                    'subcategories'=>$this->subcategories,'subcategories_links'=>$this->subcategories_links,
                ]);
            }
            throw new Exception('Token mismatch');
        }

        return null;

    }

    private function edit($id)
    {
        if(Request::has('post'))
        {
            $request= Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token,false))
            { $rules =['name'=>['required'=>true,'maxLength'=>20,'string'=>true,'unique'=>'categories']];
                $validate=new ValidateRequest;
                $validate->abide($_POST,$rules);
                if ($validate->hasError()) {
                    $errors = $validate->getErrorMessages();
                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($errors);
                    exit;
                }
                    Category::where('id',$id)->update(['name='>$request->name,]);
                    echo json_encode(['success'=>'Record Update Successfully']);
                    exit;
            }
            throw new \Exception('Token mismatch','_');
        }

        return null;

    }

    public function delete($id)
    {

        if (Request::has('post')) {

            $request = Request::get('post');

            if (CSRFToken::verifyCSRFToken($request->token)) {

                Category::destroy($id);
                $subcategories=SubCategory::where('category_id',$id)->get();
                if (count($subcategories)){
                    foreach ($subcategories as $subcategory){
                        $subcategory->delete();

                    }
                }
                Session::add('success','Category Deleted');
                Redirect::to('/admin/service/categories');

            }
            throw new Exception('Token mismatch');

        }
        return null;
    }
}