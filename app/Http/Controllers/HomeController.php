<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 現在、ログインしているユーザー情報の取得
        $user = \Auth::user();
        // メモ一覧の取得 ACDが昇順、DESCが降順
        $memos = Memo::where('user_id',$user['id'])->where('status', 1)->orderBy('updated_at', 'DESC')->get();
        return view('home', compact('user', 'memos'));
    }

    public function create()
    {
        // 現在、ログインしているユーザー情報の取得しcreateViewに渡す。
        $user = \Auth::user();
        return view('create', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す

        // // 同じタグがあるか確認
        // $exist_tag = Tag::where('name', $data['tag'])->where('user_id', $data['user_id'])->first();
        // if( empty($exist_tag['id']) ){
        //     //先にタグをインサート
        //     $tag_id = Tag::insertGetId(['name' => $data['tag'], 'user_id' => $data['user_id']]);
        // }else{
        //     $tag_id = $exist_tag['id'];
        // }
        // //タグのIDが判明する
        // // タグIDをmemosテーブルに入れてあげる
        $memo_id = Memo::insertGetId([
            'content' => $data['content'],
            'user_id' => $data['user_id'],
            // 'tag_id' => $tag_id,
            'status' => 1
        ]);

        // リダイレクト処理
        return redirect()->route('home');
    }

    public function edit($id){
        // 該当するIDのメモをデータベースから取得
        $user = \Auth::user();
        $memo = Memo::where('status', 1)->where('id', $id)->where('user_id', $user['id'])->first();
        $memos = Memo::where('user_id',$user['id'])->where('status', 1)->orderBy('updated_at', 'DESC')->get();
        //取得したメモをViewに渡す
        return view('edit',compact('memos', 'memo', 'user'));
    }
}
