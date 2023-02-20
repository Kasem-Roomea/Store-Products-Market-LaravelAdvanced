<thead class="thead-dark">
      <tr>
            <th scope="col"></th>
            <th scope="col" >{{\session()->get('local')=="Ar" ? 'الاسم' : 'name'}} </th>
            <th scope="col" >{{\session()->get('local')=="Ar" ? 'السعر' : 'price'}} </th>
            <th scope="col" >{{\session()->get('local')=="Ar" ? 'كمية' : 'quantity'}} </th>
            <th scope="col" >{{\session()->get('local')=="Ar" ? 'صورة' : 'photo'}} </th>
            <th scope="col"></th>
      </tr>
</thead>
<tbody>
      @foreach($records as $record)
            <tr class="bg-primary">
                  <th scope="row">#</th>
                  <td>{{$record->product['name'.\session()->get('local')]??""}}</td>
                  <td>{{$record->product->price??""}}</td>
                  <td>{{$record->quantity}}</td>
                  <td><a target="_blank"href="{{$record->product->images->first()->image??''}}"></a></td>
                  <td>
                  @foreach($record->features_in_carts as $features_in_carts)
                        <tr>
                              <th scope="row">{{\session()->get('local')=="Ar" ? 'إضافة' : 'addition'}}</th>
                              <td>{{$features_in_carts->feature['name'.\session()->get('local')]}}</td>
                              <td>{{$features_in_carts->feature->price}}</td>
                              <td>{{$features_in_carts->quantity}}</td>
                        </tr>
                  @endforeach
                  </td>
            </hr>
            <br>
      @endforeach
</tbody>
