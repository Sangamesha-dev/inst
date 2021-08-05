<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Course;
use App\Admin\Models\Branch;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class BranchController extends AdminController
{
    protected function title()
    {
        return trans('Branches');
    }

    protected function grid()
    {
        //$userModel = config('admin.database.users_model');

        $grid = new Grid(new  Branch());

        $grid->column('id', 'ID')->sortable();
        $grid->column('course_id', 'Course Id');
        $grid->column('branch_name', __('Branch Name'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->filter(function($filter){
            $courses = Course::all('id','course_name');
            $res = array();
            foreach ($courses as $course)
            {
                $res[$course['id']] = $course['course_name'];
            }
            $filter->like('course_id')->select($res);
        });
        return $grid;
    }
    protected function detail($id)
    {
        $show = new Show(Branch::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('course_id', __('Course Id'));
        $show->field('branch_name', __('Branch Name'));
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
        $form = new Form(new Branch);
        $courses = Course::all('id','course_name');
        $res = array();
        foreach ($courses as $course)
        {
            $res[$course['id']] = $course['course_name'];
        }
        $form->display('id', 'ID');
        $form->select('course_id','Course Id')->options($res)->rules('required');
        $form->text('branch_name', __('Branch Name'))->rules('required');
        // $form->display('created_at', __('Created at'));
        // $form->display('updated_at', __('Updated at'));

        // $form->saving(function (Form $form) {
        //     if ($form->password && $form->model()->password != $form->password) {
        //         $form->password = Hash::make($form->password);
        //     }
        // });

        return $form;
    }
}
