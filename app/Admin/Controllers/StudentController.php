<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use App\User;
use Encore\Admin\Show;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Hash;

class StudentController extends AdminController
{
    protected function title()
    {
        return trans('Students');
    }

    protected function grid()
    {
        //$userModel = config('admin.database.users_model');

        $grid = new Grid(new  User());

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('password', __('Password'));
        $grid->column('mobile', __('Mobile'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        // $grid->actions(function (Grid\Displayers\Actions $actions) {
        //     if ($actions->getKey() == 1) {
        //         $actions->disableDelete();
        //     }
        // });

        // $grid->tools(function (Grid\Tools $tools) {
        //     $tools->batch(function (Grid\Tools\BatchActions $actions) {
        //         $actions->disableDelete();
        //     });
        // });

        $grid->filter(function($filter){
            $filter->like('email','Email');
            $filter->like('mobile','Mobile');
        });

        return $grid;
    }
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('password', __('Password'));
        $show->field('mobile', __('Mobile'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);
        $userTable = 'users';
        $connection = config('admin.database.connection');

        $form->display('id', 'ID');
        $form->text('name', __('Name'))->rules('required');
        $form->email('email', __('Email'))
            ->creationRules(['required', "unique:{$connection}.{$userTable}"])
            ->updateRules(['required', "unique:{$connection}.{$userTable},email,{{id}}"]);
        $form->text('mobile', __('Mobile'))
            ->creationRules(['required', "unique:{$connection}.{$userTable}"])
            ->updateRules(['required', "unique:{$connection}.{$userTable},mobile,{{id}}"]);
        $form->password('password', __('Password'))->rules('required|confirmed');
        $form->password('password_confirmation',__('Confirm Password'))->rules('required')
            ->default(function ($form){
                return $form->model()->password;
            });
        $form->ignore(['password_confirmation']);
        // $form->display('created_at', __('Created at'));
        // $form->display('updated_at', __('Updated at'));

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });

        return $form;
    }
}
