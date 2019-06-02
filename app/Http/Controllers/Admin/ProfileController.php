<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\Profiles;

class ProfileController extends Controller
{
  public function add()
  {
      return view('admin.profile.create');
  }

  public function create(Request $request)
  {
      $this->validate($request, Profiles::$rules);

      $profiles = new Profiles;
      $form = $request->all();

      unset($form['_token']);

      $profiles->fill($form);
      $profiles->save();

      return redirect('admin/profile/create');
  }

  public function index(Request $request)
  {
      $cond_name = $request->cond_name;
      if ($cond_name != '') {
          // 検索されたら検索結果を取得する
          $posts = Profiles::where('name', $cond_name)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Profiles::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_name' => $cond_name]);
  }

  public function edit(Request $request)
  {
      $profiles = Profiles::find($request->id);
      if (empty($profiles)) {
        abort(404);
      }
      return view('admin.profile.edit', ['profiles_form' => $profiles]);
  }

  public function update(Request $request)
  {
    $this->validate($request, Profiles::$rules);
    // News Modelからデータを取得する
    $profiles = Profiles::find($request->id);
    // 送信されてきたフォームデータを格納する
    $profiles_form = $request->all();


    unset($profiles_form['_token']);
    unset($profiles_form['remove']);
    // 該当するデータを上書きして保存する
    $profiles->fill($profiles_form)->save();

    return redirect('admin/profile/');
  }

  public function delete(Request $request)
{
    // 該当するNews Modelを取得
    $news = Profiles::find($request->id);
    // 削除する
    $news->delete();
    return redirect('admin/profile/');
}
}
