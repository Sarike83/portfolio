@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="text-center">
            <h1 class="section_title">管理者画面</h1>
            <h3 class="mt-4 pb-2">ユーザー一覧</h3>
            <table class="admin_user-table table-bordered mx-auto">
                <thead>
                    <tr style="height: 32px;">
                        <th style="width: 50px;">ID</th>
                        <th style="width: 150px;">名前</th>
                        <th style="width: 300px;">e-mail</th>
                        <th style="width: 200px;" colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr style="height: 60px;">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><a href="{{ route('admin.show', $user) }}" class="btn btn-primary">詳細</a></td>
                        <td>
                            <form action="{{ route('admin.destroy', $user) }}" method="post" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection