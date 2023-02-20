<thead class="thead-dark">
      <tr>
            <th scope="col" class="list-lang" ar="كود الطلب" en="order code" ></th>
            <th scope="col" class="list-lang" ar=" اسم الزبون" en="client name" ></th>
            <th scope="col" class="list-lang" ar=" المتجر" en="store"> </th>
            <th scope="col" class="list-lang" ar=" اسم الكابتن" en="driver name"> </th>
            <th scope="col" class="list-lang" ar=" الحالة" en="status"> الحالة</th>
            <th scope="col" class="list-lang" ar="  وقت التوصيل" en="delivery time"> </th>
            <th scope="col" class="list-lang" ar=" طريقة الدفع" en="Payment method">  </th>
            <th scope="col" class="list-lang" ar="  سعر المنتجات" en="products price "> </th>
            <th scope="col" class="list-lang" ar=" سعر التوصيل" en="delivery price">  </th>
            <th scope="col" class="list-lang" ar=" الرسوم" en="fees">  </th>
            <th scope="col" class="list-lang" ar=" تاريخ" en="date"></th>
      </tr>
</thead>
<tbody>
      @foreach($records as $record)
          <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
            <td>{{$record->code}}</td>
            <td>{{$record->user->name}}</td>
            <td>{{$record->store->name}}</td>
            <td>{{$record->driver->name??"_"}}</td>
            <td  class="list-lang" ar=" {{$record->statusAr}}" en="{{$record->status}}"></td>
            <td>{{$record->deliveryTime}}</td>
            <td class="list-lang" ar=" {{$record->paymentMethodAr}}" en="{{$record->paymentMethod}}"></td>
            <td>{{$record->products_price}}</td>
            <td>{{$record->deliveryPrice}}</td>
            <td>{{$record->fees}}</td>
            <td>{{$record->createdAt}}</td>
          </tr>
      @endforeach
</tbody>
