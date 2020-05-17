<?php

namespace App\Admin\Controllers;

use App\Models\Characteristic;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Список товара';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());
        $grid->disableCreateButton();
        $grid->disableActions();

        $grid->column('id', __('Id'));
        $grid->column('name', __('Название'));
        $grid->characteristics('Список характеристик')->pluck('name','name')->label('default');
        $grid->column('price', __('Цена'))->sortable();
        $grid->column('created_at', __('Создано'))->date('Y-m-d H:i:s');
        $grid->column('updated_at', __('Изменено'))->date('Y-m-d H:i:s');

        $grid->filter(function (Grid\Filter $filter){
            $cat = new Characteristic();


            $filter->disableIdFilter();
            $filter->like('name', 'Название')->placeholder('введите название товара');
            $filter->in('characteristics.name', 'Характеристики')->multipleSelect($cat->pluck('name','name'));


        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
//    protected function detail($id)
//    {
//        $show = new Show(Product::findOrFail($id));
//
//        $show->field('id', __('Id'));
//        $show->field('name', __('Name'));
//        $show->field('price', __('Price'));
//        $show->field('created_at', __('Created at'));
//        $show->field('updated_at', __('Updated at'));
//
//        return $show;
//    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());
        $charModel = new Characteristic();



        $form->text('name', __('Название'))->rules('required');
        $form->number('price', __('Цена'))->rules('required');
        $form->multipleSelect('characteristics', __('Характеристики'))->options($charModel::all()->pluck('name', 'id'));


        return $form;
    }
}
