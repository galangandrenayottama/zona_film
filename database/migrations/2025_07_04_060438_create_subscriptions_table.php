    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('package_name'); // e.g., "Premium", "Standar"
                $table->unsignedInteger('price'); // e.g., 186000
                $table->string('payment_method'); // e.g., "OVO", "Virtual Account"
                $table->string('status')->default('active');
                $table->timestamp('paid_at');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('subscriptions');
        }
    };
    