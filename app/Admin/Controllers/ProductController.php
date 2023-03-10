<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Category;
class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        $grid->column('price', __('Price'));
        
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('category.name', __('Category Name'));
        $grid->column('image', __('Image'))->image();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $grid->column('id', __('Id'))->sortable();
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $grid->column('price', __('Price'))->sortable();
        
        $grid->column('created_at', __('Created at'))->sortable();
        
        $show->field('category.name', __('Category Name'));
        $show->field('image', __('Image'))->image();
        $grid->column('updated_at', __('Updated at'))->sortable();
 
        $grid->filter(function($filter) {
        $filter->like('name', '商品名');
        $filter->like('description', '商品説明');
        $filter->between('price', '金額');
        $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
         });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->number('price', __('Price'));
        
        $form->image('image', __('Image'));
        $form->select('category_id', __('Category Name'))->options(Category::all()->pluck('name', 'id'));
        return $form;
    }
}
