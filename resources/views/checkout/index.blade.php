@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>🔒 Secure Checkout</h1>
        <p>Complete your order below</p>
    </div>
</div>

<div class="container">
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="checkout-grid">
            {{-- Shipping Information --}}
            <div>
                <div class="card" style="margin-bottom:1.5rem;">
                    <div class="card-header"><h3>📍 Shipping Information</h3></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">First Name <span class="required">*</span></label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name', $user->name ? explode(' ', $user->name)[0] : '') }}" required>
                                @error('first_name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Last Name <span class="required">*</span></label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', explode(' ', $user->name, 2)[1] ?? '') }}" required>
                                @error('last_name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Email <span class="required">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}">
                                @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Street Address <span class="required">*</span></label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address', $user->address) }}" placeholder="123 Main St, Apt 4B" required>
                            @error('address')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">City <span class="required">*</span></label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city') }}" required>
                                @error('city')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">State <span class="required">*</span></label>
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state') }}" required>
                                @error('state')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">ZIP Code <span class="required">*</span></label>
                                <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror"
                                    value="{{ old('zip_code') }}" required>
                                @error('zip_code')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Country <span class="required">*</span></label>
                                <select name="country" class="form-control @error('country') is-invalid @enderror" required>
                                    <option value="US" {{ old('country', 'US') === 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country') === 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="GB" {{ old('country') === 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="AU" {{ old('country') === 'AU' ? 'selected' : '' }}>Australia</option>
                                    <option value="DE" {{ old('country') === 'DE' ? 'selected' : '' }}>Germany</option>
                                    <option value="FR" {{ old('country') === 'FR' ? 'selected' : '' }}>France</option>
                                </select>
                                @error('country')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="card" style="margin-bottom:1.5rem;">
                    <div class="card-header"><h3>💳 Payment Method</h3></div>
                    <div class="card-body">
                        <div style="display:flex;flex-direction:column;gap:.75rem;">
                            @foreach(['cod' => ['Cash on Delivery', '💵', 'Pay when your order arrives'], 'card' => ['Credit/Debit Card', '💳', 'Visa, Mastercard, Amex'], 'paypal' => ['PayPal', '🅿️', 'Pay via PayPal']] as $method => [$label, $icon, $desc])
                            <label style="display:flex;align-items:center;gap:1rem;padding:1rem;border:1.5px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all var(--transition);" class="payment-option">
                                <input type="radio" name="payment_method" value="{{ $method }}" {{ old('payment_method', 'cod') === $method ? 'checked' : '' }} required style="accent-color:var(--primary);">
                                <span style="font-size:1.5rem;">{{ $icon }}</span>
                                <div>
                                    <div style="font-weight:600;font-size:.9rem;">{{ $label }}</div>
                                    <div style="font-size:.8rem;color:var(--text-muted);">{{ $desc }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('payment_method')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Notes --}}
                <div class="card">
                    <div class="card-header"><h3>📝 Order Notes</h3></div>
                    <div class="card-body">
                        <textarea name="notes" class="form-control" placeholder="Special delivery instructions or notes..." rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div>
                <div class="cart-summary">
                    <div class="cart-summary-title">📦 Order Summary</div>
                    @foreach($cartItems as $item)
                    <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem 0;border-bottom:1px solid var(--border);">
                        @if($item['image'])
                            <img src="{{ asset('storage/' . $item['image']) }}" style="width:48px;height:48px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--border);" alt="">
                        @else
                            <div style="width:48px;height:48px;border-radius:var(--radius-sm);background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:1.25rem;">📦</div>
                        @endif
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:.875rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item['name'] }}</div>
                            <div style="font-size:.8rem;color:var(--text-muted);">Qty: {{ $item['quantity'] }}</div>
                        </div>
                        <div style="font-size:.875rem;font-weight:700;">${{ number_format($item['total'], 2) }}</div>
                    </div>
                    @endforeach

                    <div class="summary-row"><span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span></div>
                    <div class="summary-row"><span>Tax (8%)</span><span>${{ number_format($tax, 2) }}</span></div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>@if($shipping == 0)<span class="free">FREE</span>@else${{ number_format($shipping, 2) }}@endif</span>
                    </div>
                    <div class="summary-row total"><span>Total</span><span>${{ number_format($total, 2) }}</span></div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:1.25rem;">
                        🔒 Place Order — ${{ number_format($total, 2) }}
                    </button>
                    <div style="text-align:center;margin-top:.75rem;font-size:.78rem;color:var(--text-muted);">
                        By placing your order, you agree to our Terms of Service
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
.payment-option:has(input:checked) {
    border-color: var(--primary);
    background: rgba(99,102,241,.05);
}
</style>
@endpush
@endsection
