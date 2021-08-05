<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Branch;
use App\Admin\Models\Course;
use App\Admin\Models\Subject;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class SubjectController extends AdminController
{
    protected function title()
    {
        return trans('Subjects');
    }

    protected function grid()
    {
        //$userModel = config('admin.database.users_model');

        $grid = new Grid(new  Subject());

        $grid->column('id', 'ID')->sortable();
        $grid->column('course_id', 'Course Id');
        $grid->column('branch_id', 'Branch Id');
        $grid->column('semester_id', 'Semester Id');
        $grid->column('subject_name', __('Subject Name'));
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
        $show = new Show(Subject::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('course_id', __('Course Id'));
        $show->field('branch_id', __('Branch Id'));
        $show->field('semester_id', __('Semester Id'));
        $show->field('subject_name', __('Subject Name'));
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
        $form = new Form(new Subject);
        $form->display('id', 'ID');

        $courses = Course::all('id','course_name');
        $res = array();
        foreach ($courses as $course)
        {
            $res[$course['id']] = $course['course_name'];
        }
        $form->select('course_id','Course Id')->options($res)->rules('required');

        $branches = Branch::all('id','branch_name');
        $res = array();
        foreach ($branches as $branch)
        {
            $res[$branch['id']] = $branch['branch_name'];
        }
        $form->select('branch_id','Branch Id')->options($res)->rules('required');

        $form->text('subject_name', __('Subject Name'))->rules('required');

        return $form;
    }
}
