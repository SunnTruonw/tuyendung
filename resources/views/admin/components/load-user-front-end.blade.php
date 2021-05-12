<div class="card card-outline card-primary">
    <div class="card-header">Danh sách các thành viên</div>
    <div class="card-body table-responsive p-0 lb-list-category">
        <table class="table table-head-fixed">
            <thead>
                <tr>
                  <th>Tên </th>
                  <th>SỐ CMT</th>
                  <th>Level</th>
                  <th>R</th>
                </tr>
              </thead>
              <tbody>

                  @isset($dataUser)
                      @foreach ($dataUser as $item)
                         <tr>
                            <td><a href="{{ route('admin.user_frontend.detail',['id'=>$item->id]) }}">{{$item->name}}</a></td>
                            <td>
                                {{ $item['cmt']??"" }}
                            </td>
                            <td>{{ $item['active']?'CVKD':'CTV' }}</td>
                            <td>R{{ $item['level'] }}</td>
                        </tr>
                        @endforeach
                    @endisset

              </tbody>
        </table>
    </div>
</div>
{{ $dataUser->appends('type','user_frontend')->links() }}
