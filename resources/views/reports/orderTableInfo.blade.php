<thead class="thead-dark">
      <tr>
            <th scope="col"></th>
            <th scope="col" >{{\session()->get('local')=="aa" ? 'الاسم' : 'name'}} </th>
            <th scope="col">السعر</th>
            <th scope="col">كمية</th>
            <th scope="col">صورة</th>
            <th scope="col"></th>
      </tr>
</thead>
<tbody>
      @foreach($records as $record)
            <tr class="bg-primary">
                  <th scope="row">#</th>
                  <td>{{$record->product->nameAr??""}}</td>
                  <td>{{$record->product->price??""}}</td>
                  <td>{{$record->quantity}}</td>
                  <td><a target="_blank"href="{{$record->product->images->first()->image??''}}"><img style="height:100px;width:100px" src="{{asset($record->product->images->first()->image??'')}}"></img></a></td>
                  <td>
                  @foreach($record->features_in_carts as $features_in_carts)
                        <tr>
                              <th scope="row">إضافة</th>
                              <td>{{$features_in_carts->feature->nameAr}}</td>
                              <td>{{$features_in_carts->feature->price}}</td>
                              <td>{{$features_in_carts->quantity}}</td>
                        </tr>
                  @endforeach
                  </td>
            </hr>
            <br>
      @endforeach
</tbody>