<?php

namespace App\Models
{
    use IdeHelper\App\Models\Admin\__Role;
    use IdeHelper\App\Models\Cart\__CartItems;
    use IdeHelper\App\Models\Cart\__User;
    use IdeHelper\App\Models\CartItem\__Cart;
    use IdeHelper\App\Models\CartItem\__Product;
    use IdeHelper\App\Models\Permission\__Roles;
    use IdeHelper\App\Models\Role\__Admins;
    use IdeHelper\App\Models\Role\__Permissions;

    /**
     * @method static \IdeHelper\App\Models\__AdminQuery query()
     * @mixin \IdeHelper\App\Models\__AdminQuery
     * @method __Role role()
     */
    class Admin
    {
        public function __construct(array $attributes = []) {}
    }

    /**
     * @method static \IdeHelper\App\Models\__CartQuery query()
     * @mixin \IdeHelper\App\Models\__CartQuery
     * @method __User user()
     * @method __CartItems cartItems()
     */
    class Cart
    {
        public function __construct(array $attributes = []) {}
    }

    /**
     * @method static \IdeHelper\App\Models\__CartItemQuery query()
     * @mixin \IdeHelper\App\Models\__CartItemQuery
     * @method __Cart cart()
     * @method __Product product()
     */
    class CartItem
    {
        public function __construct(array $attributes = []) {}
    }

    /**
     * @method static \IdeHelper\App\Models\__PermissionQuery query()
     * @mixin \IdeHelper\App\Models\__PermissionQuery
     * @method __Roles roles()
     */
    class Permission
    {
        public function __construct(array $attributes = []) {}
    }

    /**
     * @method static \IdeHelper\App\Models\__ProductQuery query()
     * @mixin \IdeHelper\App\Models\__ProductQuery
     * @method \IdeHelper\App\Models\Product\__CartItems cartItems()
     */
    class Product
    {
        public function __construct(array $attributes = []) {}
    }

    /**
     * @method static \IdeHelper\App\Models\__RoleQuery query()
     * @mixin \IdeHelper\App\Models\__RoleQuery
     * @method __Permissions permissions()
     * @method __Admins admins()
     */
    class Role
    {
        public function __construct(array $attributes = []) {}
    }

    /**
     * @method static \IdeHelper\App\Models\__UserQuery query()
     * @mixin \IdeHelper\App\Models\__UserQuery
     * @method \IdeHelper\App\Models\User\__Cart cart()
     */
    class User
    {
        public function __construct(array $attributes = []) {}
    }
}

namespace IdeHelper\App\Models
{
    use App\Models\Admin;
    use App\Models\Cart;
    use App\Models\CartItem;
    use App\Models\Permission;
    use App\Models\Product;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * @method $this whereId(int|string $value)
     * @method $this whereName(string $value)
     * @method $this whereEmail(string $value)
     * @method $this wherePassword(string $value)
     * @method $this whereRoleId(int|string $value)
     * @method $this whereCreatedAt(\Illuminate\Support\Carbon|string $value)
     * @method $this whereUpdatedAt(\Illuminate\Support\Carbon|string $value)
     * @method Admin create(array $attributes = [])
     * @method Admin|Collection|null find($id, array $columns = ['*'])
     * @method Collection findMany($id, array $columns = ['*'])
     * @method Admin|Collection findOrFail($id, array $columns = ['*'])
     * @method Admin findOrNew($id, array $columns = ['*'])
     * @method Admin|null first(array|string $columns = ['*'])
     * @method Admin firstOrCreate(array $attributes, array $values = [])
     * @method Admin firstOrFail(array $columns = ['*'])
     * @method Admin firstOrNew(array $attributes = [], array $values = [])
     * @method Admin forceCreate(array $attributes = [])
     * @method Collection get(array|string $columns = ['*'])
     * @method Admin getModel()
     * @method Collection getModels(array|string $columns = ['*'])
     * @method Admin newModelInstance(array $attributes = [])
     * @method Admin sole(array|string $columns = ['*'])
     * @method Admin updateOrCreate(array $attributes, array $values = [])
     */
    class __AdminQuery extends Builder {}

    /**
     * @method $this whereId(int|string $value)
     * @method $this whereCartId(int|string $value)
     * @method $this whereProductId(int|string $value)
     * @method $this whereQuantity(mixed|string $value)
     * @method $this whereCreatedAt(\Illuminate\Support\Carbon|string $value)
     * @method $this whereUpdatedAt(\Illuminate\Support\Carbon|string $value)
     * @method CartItem create(array $attributes = [])
     * @method CartItem|Collection|null find($id, array $columns = ['*'])
     * @method Collection findMany($id, array $columns = ['*'])
     * @method CartItem|Collection findOrFail($id, array $columns = ['*'])
     * @method CartItem findOrNew($id, array $columns = ['*'])
     * @method CartItem|null first(array|string $columns = ['*'])
     * @method CartItem firstOrCreate(array $attributes, array $values = [])
     * @method CartItem firstOrFail(array $columns = ['*'])
     * @method CartItem firstOrNew(array $attributes = [], array $values = [])
     * @method CartItem forceCreate(array $attributes = [])
     * @method Collection get(array|string $columns = ['*'])
     * @method CartItem getModel()
     * @method Collection getModels(array|string $columns = ['*'])
     * @method CartItem newModelInstance(array $attributes = [])
     * @method CartItem sole(array|string $columns = ['*'])
     * @method CartItem updateOrCreate(array $attributes, array $values = [])
     */
    class __CartItemQuery extends Builder {}

    /**
     * @method $this whereId(int|string $value)
     * @method $this whereUserId(int|string $value)
     * @method $this whereCreatedAt(\Illuminate\Support\Carbon|string $value)
     * @method $this whereUpdatedAt(\Illuminate\Support\Carbon|string $value)
     * @method Cart create(array $attributes = [])
     * @method Cart|Collection|null find($id, array $columns = ['*'])
     * @method Collection findMany($id, array $columns = ['*'])
     * @method Cart|Collection findOrFail($id, array $columns = ['*'])
     * @method Cart findOrNew($id, array $columns = ['*'])
     * @method Cart|null first(array|string $columns = ['*'])
     * @method Cart firstOrCreate(array $attributes, array $values = [])
     * @method Cart firstOrFail(array $columns = ['*'])
     * @method Cart firstOrNew(array $attributes = [], array $values = [])
     * @method Cart forceCreate(array $attributes = [])
     * @method Collection get(array|string $columns = ['*'])
     * @method Cart getModel()
     * @method Collection getModels(array|string $columns = ['*'])
     * @method Cart newModelInstance(array $attributes = [])
     * @method Cart sole(array|string $columns = ['*'])
     * @method Cart updateOrCreate(array $attributes, array $values = [])
     */
    class __CartQuery extends Builder {}

    /**
     * @method $this whereId(int|string $value)
     * @method $this whereCode(string $value)
     * @method $this whereName(string $value)
     * @method Permission create(array $attributes = [])
     * @method Collection|Permission|null find($id, array $columns = ['*'])
     * @method Collection findMany($id, array $columns = ['*'])
     * @method Collection|Permission findOrFail($id, array $columns = ['*'])
     * @method Permission findOrNew($id, array $columns = ['*'])
     * @method Permission|null first(array|string $columns = ['*'])
     * @method Permission firstOrCreate(array $attributes, array $values = [])
     * @method Permission firstOrFail(array $columns = ['*'])
     * @method Permission firstOrNew(array $attributes = [], array $values = [])
     * @method Permission forceCreate(array $attributes = [])
     * @method Collection get(array|string $columns = ['*'])
     * @method Permission getModel()
     * @method Collection getModels(array|string $columns = ['*'])
     * @method Permission newModelInstance(array $attributes = [])
     * @method Permission sole(array|string $columns = ['*'])
     * @method Permission updateOrCreate(array $attributes, array $values = [])
     */
    class __PermissionQuery extends Builder {}

    /**
     * @method $this whereId(int|string $value)
     * @method $this whereName(string $value)
     * @method $this whereDescription(string $value)
     * @method $this wherePrice(float|string $value)
     * @method $this whereStock(int|string $value)
     * @method $this whereCreatedAt(\Illuminate\Support\Carbon|string $value)
     * @method $this whereUpdatedAt(\Illuminate\Support\Carbon|string $value)
     * @method Product create(array $attributes = [])
     * @method Collection|Product|null find($id, array $columns = ['*'])
     * @method Collection findMany($id, array $columns = ['*'])
     * @method Collection|Product findOrFail($id, array $columns = ['*'])
     * @method Product findOrNew($id, array $columns = ['*'])
     * @method Product|null first(array|string $columns = ['*'])
     * @method Product firstOrCreate(array $attributes, array $values = [])
     * @method Product firstOrFail(array $columns = ['*'])
     * @method Product firstOrNew(array $attributes = [], array $values = [])
     * @method Product forceCreate(array $attributes = [])
     * @method Collection get(array|string $columns = ['*'])
     * @method Product getModel()
     * @method Collection getModels(array|string $columns = ['*'])
     * @method Product newModelInstance(array $attributes = [])
     * @method Product sole(array|string $columns = ['*'])
     * @method Product updateOrCreate(array $attributes, array $values = [])
     */
    class __ProductQuery extends Builder {}

    /**
     * @method $this whereId(int|string $value)
     * @method $this whereCode(string $value)
     * @method $this whereName(string $value)
     * @method $this whereAllPermissions(bool|string $value)
     * @method Role create(array $attributes = [])
     * @method Collection|Role|null find($id, array $columns = ['*'])
     * @method Collection findMany($id, array $columns = ['*'])
     * @method Collection|Role findOrFail($id, array $columns = ['*'])
     * @method Role findOrNew($id, array $columns = ['*'])
     * @method Role|null first(array|string $columns = ['*'])
     * @method Role firstOrCreate(array $attributes, array $values = [])
     * @method Role firstOrFail(array $columns = ['*'])
     * @method Role firstOrNew(array $attributes = [], array $values = [])
     * @method Role forceCreate(array $attributes = [])
     * @method Collection get(array|string $columns = ['*'])
     * @method Role getModel()
     * @method Collection getModels(array|string $columns = ['*'])
     * @method Role newModelInstance(array $attributes = [])
     * @method Role sole(array|string $columns = ['*'])
     * @method Role updateOrCreate(array $attributes, array $values = [])
     */
    class __RoleQuery extends Builder {}

    /**
     * @method $this whereId(int|string $value)
     * @method $this whereName(string $value)
     * @method $this whereEmail(string $value)
     * @method $this whereEmailVerifiedAt(\Illuminate\Support\Carbon|string|null $value)
     * @method $this wherePassword(string $value)
     * @method $this whereRememberToken(string|null $value)
     * @method $this whereCreatedAt(\Illuminate\Support\Carbon|string $value)
     * @method $this whereUpdatedAt(\Illuminate\Support\Carbon|string $value)
     * @method User create(array $attributes = [])
     * @method Collection|User|null find($id, array $columns = ['*'])
     * @method Collection findMany($id, array $columns = ['*'])
     * @method Collection|User findOrFail($id, array $columns = ['*'])
     * @method User findOrNew($id, array $columns = ['*'])
     * @method User|null first(array|string $columns = ['*'])
     * @method User firstOrCreate(array $attributes, array $values = [])
     * @method User firstOrFail(array $columns = ['*'])
     * @method User firstOrNew(array $attributes = [], array $values = [])
     * @method User forceCreate(array $attributes = [])
     * @method Collection get(array|string $columns = ['*'])
     * @method User getModel()
     * @method Collection getModels(array|string $columns = ['*'])
     * @method User newModelInstance(array $attributes = [])
     * @method User sole(array|string $columns = ['*'])
     * @method User updateOrCreate(array $attributes, array $values = [])
     */
    class __UserQuery extends Builder {}
}

namespace IdeHelper\App\Models\Admin
{
    /**
     * @mixin \IdeHelper\App\Models\__RoleQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    class __Role {}
}

namespace IdeHelper\App\Models\Cart
{
    /**
     * @mixin \IdeHelper\App\Models\__CartItemQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\HasMany
     */
    class __CartItems {}

    /**
     * @mixin \IdeHelper\App\Models\__UserQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    class __User {}
}

namespace IdeHelper\App\Models\CartItem
{
    /**
     * @mixin \IdeHelper\App\Models\__CartQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    class __Cart {}

    /**
     * @mixin \IdeHelper\App\Models\__ProductQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    class __Product {}
}

namespace IdeHelper\App\Models\Permission
{
    /**
     * @mixin \IdeHelper\App\Models\__RoleQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    class __Roles {}
}

namespace IdeHelper\App\Models\Product
{
    /**
     * @mixin \IdeHelper\App\Models\__CartItemQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\HasMany
     */
    class __CartItems {}
}

namespace IdeHelper\App\Models\Role
{
    /**
     * @mixin \IdeHelper\App\Models\__AdminQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\HasMany
     */
    class __Admins {}

    /**
     * @mixin \IdeHelper\App\Models\__PermissionQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    class __Permissions {}
}

namespace IdeHelper\App\Models\User
{
    /**
     * @mixin \IdeHelper\App\Models\__CartQuery
     * @mixin \Illuminate\Database\Eloquent\Relations\HasOne
     */
    class __Cart {}
}
