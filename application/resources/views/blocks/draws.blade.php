@if(count($draws))
    <select name="select-draw" id="select-draw" onchange="onSelectDraw()" style="padding: 10px 0px 10px 0px; background-color: transparent; border: 0; border-bottom: 1px solid grey; font-size: 16px" >
                <option value="">Seleccione Sorteo</option>
                @foreach($draws as $element)
                    <option value="{{ $element->id }}">{{ $element->event()->first()->date }}</option>
                @endforeach
    </select>
    <div id="hour-list"></div>
@else
    <div>No hay Sorteos Disponibles</div>
@endif