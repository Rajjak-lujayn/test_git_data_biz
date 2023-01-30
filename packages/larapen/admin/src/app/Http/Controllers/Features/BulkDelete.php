<?php

namespace Larapen\Admin\app\Http\Controllers\Features;

trait BulkDelete
{
	public function bulkDelete()
	{
		// changes by rajjak for permission issue when delete admin any list record or user
		// $this->xPanel->hasAccessOrFail('delete');
		// end
		
		$redirectUrl = $this->xPanel->route;
		
		if (!request()->has('entryId')) {
			return redirect()->to($redirectUrl);
		}
		
		try {
			
			$ids = request('entryId');
			foreach ($ids as $id) {
				$res = $this->xPanel->delete($id);
			}
			
			$msg = trans('admin.The X selected items were been deleted successfully', ['countSelected' => count((array)$ids)]);
			\Alert::success($msg)->flash();
			
		} catch (\Exception $e) {
			\Alert::error($e->getMessage())->flash();
		}
		
		return redirect()->to($redirectUrl);
	}
}
