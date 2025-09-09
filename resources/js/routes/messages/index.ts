import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\MessageController::store
 * @see app/Http/Controllers/MessageController.php:0
 * @route '/messages'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/messages',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\MessageController::store
 * @see app/Http/Controllers/MessageController.php:0
 * @route '/messages'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\MessageController::store
 * @see app/Http/Controllers/MessageController.php:0
 * @route '/messages'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\MessageController::store
 * @see app/Http/Controllers/MessageController.php:0
 * @route '/messages'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\MessageController::store
 * @see app/Http/Controllers/MessageController.php:0
 * @route '/messages'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
const messages = {
    store,
}

export default messages