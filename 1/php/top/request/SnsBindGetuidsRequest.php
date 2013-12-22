<?php
/**
 * TOP API: taobao.sns.bind.getuids request
 * 
 * @author auto create
 * @since 1.0, 2013-12-18 16:53:48
 */
class SnsBindGetuidsRequest
{
	/** 
	 * 需要获取密文的明文uid串，之间以‘，’分割
	 **/
	private $uids;
	
	private $apiParas = array();
	
	public function setUids($uids)
	{
		$this->uids = $uids;
		$this->apiParas["uids"] = $uids;
	}

	public function getUids()
	{
		return $this->uids;
	}

	public function getApiMethodName()
	{
		return "taobao.sns.bind.getuids";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->uids,"uids");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
