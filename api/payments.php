<?

/**
 * @file payments.php
 * @category api
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2014 by Igor Mats
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License v3
 * @all rights granted under this License are granted for the term of
 * copyright on the Program, and are irrevocable provided the stated
 * conditions are met.  This License explicitly affirms your unlimited
 * permission to run the unmodified Program.  The output from running a
 * covered work is covered by this License only if the output, given its
 * content, constitutes a covered work.  This License acknowledges your
 * rights of fair use or other equivalent, as provided by copyright law.
 *
 */

/**
 *
 * Users definition
 *
 */
namespace API
{

  /**
   * 
   * Require API components.
   *
   */
  require_once('component.php');

  class payments extends component
  {

    /**
     *
     *
     *
     */
    public function show()
    {
      if($this->available())
      {
        $promo = $this->validate('promo');
        $item = $this->validate('item');

        $this->controller->assign('promo', $promo);
        $this->controller->assign('codes', $this->queries('payments.promo.codes'));
        $this->controller->assign_element($this->get(), 'item');
        $this->response('payments', array(
          'layout' => $this->controller->fetch('ApiController/paymentsbox.html'),
          'secret' => $this->secret
        ));
      }
      else
      {
        $this->controller->abort(3);
      }
    }

    /**
     *
     *
     *
     */
    public function available()
    {
      return $this->queries('payments.available');
    }

    /**
     *
     *
     *
     */
    public function get()
    {
      return $this->queries('payments.get');
    }

    /**
     *
     *
     *
     */
    public function visit($success = false)
    {
      $this->queries($success ? 'payments.visit.true' : 'payments.visit.false');

      if(!$success)
      {
        $this->response('payments', array(
          'secret' => $this->secret
        ));
      }
    }
  }
}

/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2014
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2014 by Igor Mats
 *
 */
