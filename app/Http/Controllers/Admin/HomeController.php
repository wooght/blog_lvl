<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Articles;
use Illuminate\Support\Facades\Input;
use Redirect;
/**
后台默认控制器
文章操作相关功能
*/
class HomeController extends Controller
{
  /**
  构造指定中间件 middleware auth
  */
  public function __construct()
  {
      $this->middleware('auth.admin:admin');
  }

  /**
  默认方法
   */
  public function index()
  {
    //文章列表
    $at=new Articles;
    $list=$at->join('users',function($users){
      $users->on('articles.user_id','=','users.id');
    })->select('articles.id as id','articles.article_title','articles.created_at','users.name','reads','comments')->get();
    return view('admin/home')->withList($list);
  }
  /**
  删除文章
  */
  public function destore($id){
    $art=Articles::find($id);
    if($art->delete()){
      return Redirect::to('/');
    }
    return Redirect::to('/')->withError('删除失败!');
  }
  /**
  执行修改
  */
  public function update(Request $request,$id){
    $this->validate($request,[
      'title' => 'required|max:35',
      'body' => 'required|min:10'
    ],[
      'title.required' => '标题必须填写','title.max' => '标题必须在35字以内','body.required' => '必须填写内容'
    ]);

    $ats=Articles::find($id);
    $ats->article_title=Input::get('title');
    $ats->article_body=Input::get('body');
    if($ats->save()){
      return Redirect::to('admin/article/'.$id.'/edit')->withOk('修改成功!');
      /*
      withOk('')  将内容存放在session中供重定向后使用.
      */
    }
    return Redirect::to('/');
  }
  /**
  编辑文章
  */
  public function edit($id){
    if(!Articles::find($id)){
      return view('admin.home')->withError('没有此文章');
    }
    $arts=Articles::join('users',function($users){
      $users->on('articles.user_id','=','users.id');
    })->select('articles.id as id','articles.article_title','articles.article_body','users.name','reads','comments')->find($id);
    return view('admin.article')->withArts($arts);
  }
  public function haha(){
    dd('后台首页，当前用户名：'.auth('admin')->user()->name);
  }
}