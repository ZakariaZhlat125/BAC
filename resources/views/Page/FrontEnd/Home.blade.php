<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    @include('components.top-section-front')

    <div class="container mt-4">
        <p class="text-center mb-4"
            style="font-size: 32px; margin-inline: 10%;  color: black; padding: 20px; border-radius: 10px;">


            هنا تبدأ رحلتك نحو التميّز<br> تشرح، تتعلّم، تحضر فعاليات، وتكسب نقاط تطوعية وشهادات تطوعية معتمدة.
            شارك زملاءك المعرفة، أنشئ محتوى تعليمي، نظّم ورش عمل وسيمينارات، وكن جزءًا من بيئة تفاعلية تدعم تطورك
            الأكاديمي .<br>
            كل تفاعل له قيمة، وكل إنجاز يصنع لك أثرًا في سجلّك الجامعي.<br>
            ابدأ رحلتك التعليمية الآن 🚀</p>
    </div>
    <section class="features py-5">
        <div class="container">
            <div class="row g-4">

                <div class="col-md-4">
                    <div class="feature-card card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <img src="assets/img/ic_activtes.png" style="width: 100px; height: 100px;"
                                    class="fas fa-book-open"></i>
                            </div>
                            <h3 class="card-title h4">الفعاليات المعتمدة</h3>
                            <p class="card-text">شارك في ورش عمل، ندوات، وفعاليات خاصة بأعمال الكلية، واكتسب شهادات
                                تطوعية معتمدة من الكلية.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <img src="assets/img/ic_edu.png" style="width: 100px; height: 100px;"
                                    class="fas fa-book-open"></i>
                            </div>
                            <h3 class="card-title h4">المحتوى التعليمي</h3>
                            <p class="card-text">اطّلع على شروحات ومحاضرات ومختلف أنواع المحتوى التدريبي المتعدد لتعزيز
                                فهمك للمقررات الأكاديمية.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <img src="assets/img/ic_points.png" style="width: 100px; height: 100px;"
                                    class="fas fa-book-open"></i>
                            </div>
                            <h3 class="card-title h4">النقاط والشهادات</h3>
                            <p class="card-text">اجمع نقاطًا من خلال تفاعلاتك ومشاركاتك، واحصل على شهادات معتمدة تُثري
                                سيرتك الذاتية والسجل الأكاديمي.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-events :events="$events" />


    <br>
    <br>
    <br>
    <x-open-data :countEvents="$countEvents" :countStudents="$countStudents" />



</x-app-layout>
