<thead class="thead-dark">
      <tr>
            <th scope="col " class="list-lang" ar="كود الطلب" en=" order code"></th>
            <th scope="col"  class="list-lang" ar="المتجر" en=" store"> </th>
            <th scope="col"  class="list-lang" ar="السائق" en=" driver"> </th>
            <th scope="col"  class="list-lang" ar="المستخدم" en=" user"> </th>
            <th scope="col"  class="list-lang" ar="المسافة" en=" distance"> </th>
            <th scope="col"  class="list-lang" ar="الحالة" en=" status"> </th>
            <th scope="col" class="list-lang" ar="تفاصيل الطلب" en=" details"> </th>
            <th scope="col"></th>
      </tr>
</thead>
<tbody>
      @foreach($records as $record)
            <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
                  <td>{{$record->code}}</td>
                  <td>{{$record->store->name??""}}</td>
                  <td>{{$record->driver->name??""}}</td>
                  <td>{{$record->user->name??""}}</td>
                  <td>{{$record->distance}}</td>
                  <td class="list-lang" ar="{{$record->statusAr}}" en="{{$record->status}}"></td>
                  <td>
                        <button class="btn-sm btn btn-success orderInfo mb-1" data-toggle="modal" data-target="#orderInfo-modal"><i class="fas fa-shopping-cart"></i></button>
                  </td> 
                  <td>
                        <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
                  </td>
          </tr>
      @endforeach
</tbody>
