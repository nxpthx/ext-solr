<?php
namespace ApacheSolrForTypo3\Solr\ResultDocumentModifier;

class CollapseExpansion implements ResultDocumentModifier {

	/**
	 * Modifies the given document and returns the modified document as result.
	 *
	 * @param \Tx_Solr_PiResults_ResultsCommand $resultCommand The search result command
	 * @param array $resultDocument Result document as array
	 *
	 * @return array The document with fields as array
	 */
	public function modifyResultDocument($resultCommand, array $resultDocument)
	{
		$search = $resultCommand->getParentPlugin()->getSearch();
		$response = $search->getResponse();

		if ($search->getQuery()->isCollapsing()) {
			$resultDocument['expanded'] = array();
			$collapseId = $resultDocument[$search->getQuery()->getCollapseField()];
			if (isset($response->{'expanded'}) && $response->{'expanded'}->{$collapseId}) {
				foreach ($response->{'expanded'}->{$collapseId}->{'docs'} as $expandedDocument) {
					$resultDocument['expanded'][] = (array) $expandedDocument;
				}
			}
		}
		return $resultDocument;
	}
}