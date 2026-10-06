@foreach ($questions as $i => $item)
    <fusion:faq-item :question="$item['question']" :answer="$item['answer']" :key="$i" />
@endforeach
